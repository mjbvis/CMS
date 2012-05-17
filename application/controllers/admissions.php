<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class admissions extends Application {

	private static $data = array();

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard', 'ag_auth', 'menu'));

		# Load Libraries

		# Load Modules
		$this->load->library('Repositories/Admissions_Repository', '', 'reg');

		# setup default view data
		$this->data['title'] = 'Admissions Dashboard';
		$this->data['MenuItems'] = get_menu_items();	// no argument means use current gruop
	}
    
    public function index()
    {
        if(logged_in())
        {
            /* load views */
            $this->load->view('templates/header', $this->data);
            $this->load->view('admissions/dashboard', $this->data);
            $this->load->view('templates/footer', $this->data);
        }
        else
        {
            $this->login();
        }
    }

	// view the Montessori policy and statements of value
	function policy() {
		$this->load->view('templates/header', $this->data);
		$this->load->view('admissions/forms/policy', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	// Manages the waitlist_questionaire. Handles displaying the
	// questionaire, validating the questionaire, and saving the form.
	function waitlistQuestionaire() {		
		// get all enabled questions
		$wlQuestions = Waitlist_question::find_all_by_enabled(1);

		// get all enabled program groups AND filter out program groups with no enabled programs
		// NOTE: Programs will be eager loaded but must be filtered by enabled in the view
		$join = 'INNER JOIN Program ON Program.ProgramGroupID = ProgramGroup.ProgramGroupID AND Program.Enabled = 1';
		$progGroups = Program_group::all(array('joins' => $join
											  ,'conditions' => array('ProgramGroup.Enabled=?', 1)));

		// send these questions and programs to the view for display
		$this->data['wlQuestions'] = $wlQuestions;
		$this->data['progGroups'] = $progGroups;

		# Set up validation for admissionsPage1.php
		$this->validateWaitlistQuestionaire($wlQuestions, $progGroups);

		// if user is posting back answers, then save the form
		if($this->form_validation->run() == TRUE) {
			// get answers from waitlist questionaire
			$this->storeWaitListForm($wlQuestions, $progGroups);

			// display waitlist and pre-enrolled students for this parent
			redirect('admissions/registerStudentSelector');
		}
		else{	
			// display the waitlist questionaire
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admissions/forms/waitlist_questionaire', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
	}

	// Displays the list of all waitlisted students for the current user.
	// 	That is, the waitlisted students who were waitlisted by the current
	// 	user AND who have been approved for registration.
	function registerStudentSelector() {
		$this->data['preEnStudents'] = Waitlist_form::all(
				array('conditions' => array('UserID=? AND IsPreEnrolled=1', user_id())
					 ,'joins' => array('user')));

		$this->data['wlStudents'] = Waitlist_form::all(
				array('conditions' => array('UserID=? AND IsPreEnrolled=0', user_id())
					 ,'joins' => array('user')));

		$this->load->view('templates/header', $this->data);	
		$this->load->view('admissions/forms/register_student_selection');
		$this->load->view('templates/footer');
	}


	// Manages the register_student form. Handles displaying the
	// form, validating the form, and saving the form.
	// We are registering the student represented by the given
	// waitlist ID, wlid.
	function registerStudent($wlid = '') {

		// verify that this student belongs to this user
		$wlStud = Waitlist_form::find(array('conditions' => array('FormID=? AND UserID=?', $wlid, user_id())));
		if($wlStud == null || empty($wlStud)){
			redirect('login');
		}

		// get all enabled program groups AND filter out program groups with no enabled programs
		// NOTE: Programs will be eager loaded but must be filtered by enabled in the view
		$join = 'INNER JOIN Program ON Program.ProgramGroupID = ProgramGroup.ProgramGroupID AND Program.Enabled = 1';
		$progGroups = Program_group::all(array('joins' => $join
											  ,'conditions' => array('ProgramGroup.Enabled=?', 1)));

		// populate view data with child info and program info
		$this->data['firstName'] = $wlStud->firstname;
		$this->data['middleName'] = $wlStud->middlename;
		$this->data['lastName'] = $wlStud->lastname;
		$this->data['progSelected'] = $wlStud->expectedprogramid;
		$this->data['progGroups'] = $progGroups;

		# Validation for the student registration process
		$this->validateRegistrationForm();
		if($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admissions/forms/register_student');
			$this->load->view('templates/footer');
		}
		else {
			$this->storeRegistrationForm($wlid);

			// display waitlist and pre-enrolled students for this parent
			redirect('admissions/registerStudentSelector');
		}
	}

	# saves the completed Waitlist Questionaire
	function storeWaitlistForm($questions){
		// save waitlist form to DB		
		$wlForm = new Waitlist_form();
		$wlForm->userid = user_id();
		$wlForm->expectedprogramid = set_value('programChecked');
		$wlForm->firstname = set_value('cFirstName');
		$wlForm->middlename = set_value('cMiddleName');
		$wlForm->lastname = set_value('cLastName');
		$wlForm->agreement = set_value('pAgreement');
		$wlForm->ispreenrolled = 0;
		$wlForm->iswaitlisted = 1;
		$wlForm->submissiondttm = date('Y-m-d H:i:s', time()); // Example: 2012-11-28 14:32:08
		$wlForm->save();

		// store each answer from the waitlist questionaire form
		$i = 0;
		foreach($questions as $q){
			$wlAnswer = new Waitlist_form_question();
			$wlAnswer->formid = $wlForm->formid;
			$wlAnswer->questionid = $q->questionid;
			$wlAnswer->answer = set_value('q' . $i . 'answer');
			$wlAnswer->save();

			$i++;
		}
	}

	# saves the registration form
	function storeRegistrationForm($wlid){

		// make submission of multiple tables to database atomic.
		Admissions_form::transaction(function() use ($wlid){

			// do this to disable the new student from being re-registered
			$waitlistform = Waitlist_form::find_by_formid($wlid);
			$waitlistform->iswaitlisted = 0;
			$waitlistform->ispreenrolled = 0;
			$waitlistform->save();

			// must save 3 emergency contacts 1st
			$emergencyContact1 = new Emergency_contact();
			$emergencyContact1->ecname = set_value('emergencyContactName1');
			$emergencyContact1->ecphone = set_value('emergencyContactPhone1');
			$emergencyContact1->ecrelationship = set_value('emergencyContactRelationship1');
			$emergencyContact1->save();

			$emergencyContact2 = new Emergency_contact();
			$emergencyContact2->ecname = set_value('emergencyContactName2');
			$emergencyContact2->ecphone = set_value('emergencyContactPhone2');
			$emergencyContact2->ecrelationship = set_value('emergencyContactRelationship2');
			$emergencyContact2->save();

			$emergencyContact3 = new Emergency_contact();
			$emergencyContact3->ecname = set_value('emergencyContactName3');
			$emergencyContact3->ecphone = set_value('emergencyContactPhone3');
			$emergencyContact3->ecrelationship = set_value('emergencyContactRelationship3');
			$emergencyContact3->save();

			// must save the student 2nd
			$student = new Student();
			$student->userid = user_id();
			$student->classid = null;		// admin decides classroom later in the admissions process
			$student->programid = set_value('programChecked');
			$student->firstname = set_value('cFirstName');
			$student->middlename = set_value('cMiddleName');
			$student->lastname = set_value('cLastName');
			$student->gender = set_value('cGender');
			$student->address = set_value('cAddress');
			$student->placeofbirth = set_value('cBirthplace');
			$student->dob = date('Y-m-d H:i:s', strtotime(set_value('cDOB')));
			$student->phonenumber = set_value('cPhoneNum');
			$student->emergencycontactid1 = $emergencyContact1->contactid;
			$student->emergencycontactid2 = $emergencyContact2->contactid;
			$student->emergencycontactid3 = $emergencyContact3->contactid;
			$student->questionaireid = $wlid;
			$student->isenrolled = 0;
			$student->udttm = date('Y-m-d H:i:s', time()); // Example: 2012-11-28 14:32:08
			$student->enrollmentdttm = null;
			$student->save();

			// save the Admissions_form last to complete the transaction
			$form = new Admissions_form();
			$form->studentid = $student->studentid;
			$form->schoolexperience = set_value('daycareExperience');
			$form->socialexperience = set_value('socialExperience');
			$form->comfortmethods = set_value('comfortMethod');
			$form->toilet = set_value('toiletNeeds');
			$form->naptime = set_value('napTime');
			$form->outdoorplay = set_value('playOutside');
			if(set_value('HasPets') == "1"){
				$form->pets = set_value('petType') . " : " . set_value('petName');
			}
			$form->interests = set_value('childInterestsName');
			$form->siblingnames = set_value('siblingOneName');
			$form->siblingages = set_value('siblingOneAge');
			$form->referrertype = set_value('referenceType');
			$form->referredby = set_value('referenceName');
			$form->notes = set_value('otherImportantInfo');
			$form->save();
		});
	}

	# saves the medical information to the database
	function storeMedicalInformation() {
		$data = array(
			'cFirst' => set_value('cFirstName'),
			'cLast' => set_value('cLastName'),
			'dob' => set_value('dobName'),
			'contactOneFirst' => set_value('contactOneFirstName'),
			'contactOneLast' => set_value('contactOneLastName'),
			'contactOnePhone' => set_value('contactOnePhoneName'),
			'contactOneAddress' => set_value('contactOneAddressName'),
			'contactTwoFirst' => set_value('contactTwoFirstName'),
			'contactTwoLast' => set_value('contactTwoLastName'),
			'contactTwoPhone' => set_value('contactTwoPhoneName'),
			'contactTwoAddress' => set_value('contactTwoAddressName'),
			'hospital' => set_value('hospitalName'),
			'hospitalPhone' => set_value('hospitalPhoneName'),
			'physician' => set_value('physicianName'),
			'physicianPhone' => set_value('physicianPhoneName'),
			'medicalProblems' => set_value('medicalProblemsName'),
			'medicalAllergies' => set_value('medicalAllergiesName'),
			'insurance' => set_value('insuranceName'),
			'insuranceCompany' => set_value('insuranceCompanyName'),
			'groupNumber' => set_value('groupNumberName'),
			'nameOfInsured' => set_value('nameOfInsuredName'),
			'employer' => set_value('employerName')
		);
	}

	# sets the validation rules
	function validateWaitlistQuestionaire($questions, $progGroups){
		// validate name (don't require middle name)
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cMiddleName', 'Child\'s Middle Name', '');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');

		// make sure a program was selected
		$this->form_validation->set_rules('programChecked', 'Program', 'required|callback_field_exists');

		// validate all questions on the form
		$i = 0;
		foreach($questions as $q){
			$this->form_validation->set_rules('q' . $i . 'answer', 'question#' . $i . '\'s answer', 'required|min_length[1]|callback_field_exists');
			$i++;
		}

		$this->form_validation->set_rules('pAgreement', 'Policy Agreement', 'required|callback_field_exists');
	}

	// Sets the validation rules for the Student Registration Form
	function validateRegistrationForm() {
		// validate name (don't require middle name)
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cMiddleName', 'Child\'s Middle Name', '');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');

		// make sure a program was selected
		$this->form_validation->set_rules('programChecked', 'Program', 'required|callback_field_exists');

		// verify 3 emergency contacts
		$this->form_validation->set_rules('emergencyContactName1', 'Emergency Contact#1\'s Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactPhone1', 'Emergency Contact#1\'s Phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactRelationship1', 'Emergency Contact#1\'s Relationship to child', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactName2', 'Emergency Contact#2\'s Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactPhone2', 'Emergency Contact#2\'s Phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactRelationship2', 'Emergency Contact#2\'s Relationship to child', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactName3', 'Emergency Contact#3\'s Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactPhone3', 'Emergency Contact#3\'s Phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('emergencyContactRelationship3', 'Emergency Contact#3\'s Relationship to child', 'required|min_length[1]|callback_field_exists');

		$this->form_validation->set_rules('cAddress', 'Child\'s Address', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cPhoneNum', 'Child\s Phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cBirthplace', 'Child\s birthplace', 'required|min_length[2]|callback_field_exists');
		$this->form_validation->set_rules('cDOB', 'Date of Birth', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('cGender', 'Gender', 'required|callback_field_exists');
		$this->form_validation->set_rules('daycareExperience', 'Daycare Experiences', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('socialExperience', 'Social Experiences', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('comfortMethod', 'Comfort your child', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('toiletNeeds', 'Toilet Needs', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('napTime', 'Takes Naps', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('playOutside', 'Plays outside', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('HasPets', 'Has Pets', 'required');
		$this->form_validation->set_rules('petType', 'Type of Pet', '');
		$this->form_validation->set_rules('petName', 'Name of Pet', '');
		$this->form_validation->set_rules('childInterestsName', 'Child\'s Interests', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('siblingOneName', 'Silbing\'s first name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('siblingOneAge', 'Silbing\'s age', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('otherImportantInfo', 'Other Important Information', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('referenceType', 'Heard about us', 'required|min_length[1]|callback_field_exists');

		// should not be validated
		$this->form_validation->set_rules('referenceName', 'Learned About us', '');
	}

	// sets the validation rules for the MedicalInformationForm
	function validateMedicalInformation() {
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('dobName', 'Date of Birth', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactOneFirstName', 'Contact First Name', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactOneLastName', 'Contact Last Name', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactOnePhoneName', 'Contact Phone Number' ,'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactOneAddressName', 'Contact Address', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactTwoFirstName', 'Contact First Name', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactTwoLastName', 'Contact Last Name', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactTwoPhoneName', 'Contact Phone Number' ,'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactTwoAddressName', 'Contact Address', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('hospitalName', 'Hospital\'s name','required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('hospitalPhone', 'Hospital\'s phone number', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('physicianName', 'Physician\'s name', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('medicalProblemsName', 'Medical Problems', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('medicalAllergiesName', 'Medical Allergies', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('insuranceName', 'Insurance', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('insuranceCompanyName', 'Insurance Company Name', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('groupNumberName', 'Group Number', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('nameOfInsuredName', 'Name of Insured', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('employerName', 'Employer', 'required|min_length[4]|callback_field_exists');
	}

	function studentMedical($studentId) {
			$data['studentMedicalInformation'] = Student_medical::find_by_studentid($studentId);
			$data['studentInsurance'] = Student_insurance::find_by_studentid($studentId);

			$this->load->view('templates/header', $this->data);  
			$this->load->view('admissions/forms/student_medical', $data);
			$this->load->view('templates/footer');
	}

	function saveStudentMedical() {
		// Set up the MedicalInformation data which will be saved in the StudentMedicalInformation table. 
		$studentId = 1;
		$hospital = $this->input->post('preferredHospitalName');
		$hospitalPhone = $this->input->post('hospitalPhoneName');
		$physician = $this->input->post('physicianName');
		$physicianPhone = $this->input->post('pPhoneName');
		$dentist = $this->input->post('dentistName');
		$dentistPhone = $this->input->post('dPhoneName');
		$medicalConditions = $this->input->post('medicalConditionsName');
		$allergies = $this->input->post('allergiesName');

		// This will save the information to the StudentMedicalInformation table.
		$this->createMedicalInformation($studentId, $hospital, $hospitalPhone, $physician, $physicianPhone, $dentist, $dentistPhone, $medicalConditions, $allergies);

		// Set up the InsuranceInformation data which will be saved in the InsuranceInformation table.
		$insuranceCompany = $this->input->post('insuranceCompanyName');
		$certificateNumber = $this->input->post('certificateNumberName');
		$insured = $this->input->post('insuredName');
		$employer = $this->input->post('employerName');

		// This will save the information to the InsuranceInformation table.
		$this->createInsuranceInformation($studentId, $insuranceCompany, $certificateNumber, $insured, $employer);
	}

		function createMedicalInformation($studentId, $hospital, $hospitalPhone, $physician, $physicianPhone, $dentist, $dentistPhone, $medicalConditions, $allergies) { 
			$student_medical = new Student_medical();
	        $student_medical->studentid = $studentId;
	        $student_medical->preferredhospital = $hospital;
	        $student_medical->hospitalphone = $hospitalPhone;
	        $student_medical->physician = $physician;
	        $student_medical->physicianphone = $physicianPhone;
			$student_medical->dentist = $dentist;
			$student_medical->dentistphone = $dentistPhone;
			$student_medical->medicalconditions = $medicalConditions;
			$student_medical->allergies = $allergies;
	        $student_medical->save();
		}

		function createInsuranceInformation($studentId, $insuranceCompany, $certificateNumber, $insured, $employer) {
			$student_insurance = new Student_insurance();
			$student_insurance->studentid = $studentId;
			$student_insurance->insurancecompany = $insuranceCompany; 
			$student_insurance->certificatenumber = $certificateNumber;
			$student_insurance->nameofinsured = $insured;
			$student_insurance->employer =$employer;
			$student_insurance->save();
		}
}