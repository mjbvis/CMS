<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admissions extends Application {

	private static $globalViewData = array();

	function __construct() {
		parent::__construct();

		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard', 'ag_auth', 'menu', 'notification'));

		# Load Libraries

		# setup default view data
		$this->globalViewData['title'] = 'Admissions Dashboard';
		$this->globalViewData['MenuItems'] = get_menu_items();		// no argument means use current gruop
		
	}

	function index() {
		if (logged_in()) {
			/* load views */
			$this->load->view('templates/header', $this->globalViewData);
			$this->load->view('admissions/dashboard');
			$this->load->view('templates/footer');
		} else {
			$this->login();
		}
	}

	# view the Montessori policy and statements of value
	function policy() {
		$this->load->view('templates/header', $this->globalViewData);
		$this->load->view('admissions/forms/policy');
		$this->load->view('templates/footer');
	}

	# Manages the waitlist_questionaire. Handles displaying the
	# questionaire, validating the questionaire, and saving the form.
	function waitlistQuestionaire() {
		// get all enabled questions
		$wlQuestions = Waitlist_question::find_all_by_enabled(1);

		// get all enabled program groups AND filter out program groups with no enabled programs
		// NOTE: Programs will be eager loaded but must be filtered by enabled in the view
		$join = 'INNER JOIN Program ON Program.ProgramGroupID = ProgramGroup.ProgramGroupID AND Program.Enabled = 1';
		$progGroups = Program_group::all(array('joins' => $join, 'conditions' => array('ProgramGroup.Enabled=?', 1)));

		// send these questions and programs to the view for display
		$viewData['wlQuestions'] = $wlQuestions;
		$viewData['progGroups'] = $progGroups;

		# Set up validation for admissionsPage1.php
		$this->validateWaitlistQuestionaire($wlQuestions, $progGroups);

		// if user is posting back answers, then save the form
		if ($this->form_validation->run() == TRUE) {
			// get answers from waitlist questionaire
			$this->storeWaitListForm($wlQuestions, $progGroups);

			// display waitlist and pre-enrolled students for this parent
			redirect('admissions/registerStudentSelector');
		} else {
			// display the waitlist questionaire
			$this->load->view('templates/header', $this->globalViewData);
			$this->load->view('admissions/forms/waitlist_questionaire', $viewData);
			$this->load->view('templates/footer');
		}
	}

	# Displays the list of all waitlisted students for the current user.
	# 	That is, the waitlisted students who were waitlisted by the current
	# 	user AND who have been approved for registration.
	function registerStudentSelector() {
		$viewData['preEnStudents'] = Waitlist_form::all(array('conditions' => array('UserID=? AND IsPreEnrolled=1', user_id()), 'joins' => array('user')));

		$viewData['wlStudents'] = Waitlist_form::all(array('conditions' => array('UserID=? AND IsPreEnrolled=0', user_id()), 'joins' => array('user')));

		$this->load->view('templates/header', $this->globalViewData);
		$this->load->view('admissions/forms/register_student_selection', $viewData);
		$this->load->view('templates/footer');
	}

	# Manages the register_student form. Handles displaying the
	# form, validating the form, and saving the form.
	# We are registering the student represented by the given
	# waitlist ID, wlid.
	function registerStudent($wlid='0') {
		
		// verify that this student belongs to this user
		$wlStud = Waitlist_form::find(array('conditions' => array('FormID=? AND UserID=?', $wlid, user_id())));
		if ($wlStud == null || empty($wlStud)) {
			redirect('login');
		}

		// get all enabled program groups AND filter out program groups with no enabled programs
		// NOTE: Programs will be eager loaded but must be filtered by enabled in the view
		$join = 'INNER JOIN Program ON Program.ProgramGroupID = ProgramGroup.ProgramGroupID AND Program.Enabled = 1';
		$progGroups = Program_group::all(array('joins' => $join, 'conditions' => array('ProgramGroup.Enabled=?', 1)));

		// populate view data with child info and program info
		$viewData['firstName'] = $wlStud->firstname;
		$viewData['middleName'] = $wlStud->middlename;
		$viewData['lastName'] = $wlStud->lastname;
		$viewData['progSelected'] = $wlStud->expectedprogramid;
		$viewData['progGroups'] = $progGroups;

		# Validation for the student registration process
		$this -> validateRegistrationForm();
		if ($this->form_validation -> run() == FALSE) {
			$this->load->view('templates/header', $this->globalViewData);
			$this->load->view('admissions/forms/register_student', $viewData);
			$this->load->view('templates/footer');
		} else {
			$this->storeRegistrationForm($wlid);

			// display waitlist and pre-enrolled students for this parent
			redirect('admissions/registerStudentSelector');
		}
	}


	# Displays the list of all students that lack medical info belonging
	# to the current parent.
	function studentMedicalSelector() {
		$data['Student'] = Student::all(array('conditions' => array('UserID=? AND IsEnrolled=0', user_id()), 'joins' => array('user', 'insurance_information')));

		$data['wlStudents'] = Waitlist_form::all(array('conditions' => array('UserID=? AND IsPreEnrolled=0', user_id()), 'joins' => array('user')));

		$this->load->view('templates/header', $this->globalViewData);
		$this->load->view('admissions/forms/register_student_selection');
		$this->load->view('templates/footer');
	}

	function studentMedical($studentId) {

		// verify that this student belongs to this user
		$student = Student::find(array('conditions' => array('StudentID=? AND UserID=?', $studentId, user_id())));
		if ($student == null || empty($student)) {
			// redirect to login. The login controller decides where to go from there.
			redirect('login');
		}

		// verify that this student has no medical info
		$medInfo = Student_medical::find_by_studentid($studentId);
		if ($medInfo != null || !empty($medInfo)) {
			// redirect to login. The login controller decides where to go from there.
			redirect('login');
		}

		// populate view data with relevant child info
		$viewData['firstName'] = $student->firstname;
		$viewData['middleName'] = $student->middlename;
		$viewData['lastName'] = $student->lastname;

		// Validation for the student registration process
		$this->validateMedicalForm();
		if ($this->form_validation -> run() == FALSE) {
			$this->load->view('templates/header', $this->globalViewData);
			$this->load->view('admissions/forms/student_medical', $viewData);
			$this->load->view('templates/footer');
		} else {
			$this->storeMedicalForm($studentId);

			// display list of students who have yet to fill out their medical form
			redirect('login');
		}
	}

	# saves the completed Waitlist Questionaire
	function storeWaitlistForm($questions) {
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
		$wlForm->submissiondttm = date('Y-m-d H:i:s', time());
		// Example: 2012-11-28 14:32:08
		$wlForm->save();

		// store each answer from the waitlist questionaire form
		$i = 0;
		foreach ($questions as $q) {
			$wlAnswer = new Waitlist_form_question();
			$wlAnswer->formid = $wlForm->formid;
			$wlAnswer->questionid = $q->questionid;
			$wlAnswer->answer = set_value('q' . $i . 'answer');
			$wlAnswer->save();

			$i++;
		}

		unsetNotification('waitlistAChild', user_id());
	}

	# saves the admissions form
	function storeRegistrationForm($wlid) {

		// make submission of multiple tables to database atomic.
		Admissions_form::transaction(function() use ($wlid) {

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
			$student->classid = null;
			// admin decides classroom later in the admissions process
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
			$student->udttm = date('Y-m-d H:i:s', time());
			// Example: 2012-11-28 14:32:08
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
			if (set_value('HasPets') == "1") {
				$form -> pets = set_value('petType') . " : " . set_value('petName');
			}
			$form->interests = set_value('childInterestsName');
			$form->siblingnames = set_value('siblingOneName');
			$form->siblingages = set_value('siblingOneAge');
			$form->referrertype = set_value('referenceType');
			$form->referredby = set_value('referenceName');
			$form->notes = set_value('otherImportantInfo');
			$form->save();
			
			setNotification('MedicalInformation', user_id(), $student->studentid);
		});
	}

	# saves the medical form to the DB
	function storeMedicalForm($studentId) {
		// This will save the information to the StudentMedicalInformation table.
		$student_medical = new Student_medical();
		$student_medical->studentid = $studentId;
		$student_medical->preferredhospital = set_value('preferredHospitalName');
		$student_medical->hospitalphone = set_value('hospitalPhoneName');
		$student_medical->physician = set_value('physicianName');
		$student_medical->physicianphone = set_value('pPhoneName');
		$student_medical->dentist = set_value('dentistName');
		$student_medical->dentistphone = set_value('dPhoneName');
		$student_medical->medicalconditions = set_value('medicalConditionsName');
		$student_medical->allergies = set_value('allergiesName');
		$student_medical->insurancecompany = set_value('insuranceCompanyName');
		$student_medical->certificatenumber = set_value('certificateNumberName');
		$student_medical->employer = set_value('employerName');
		$student_medical->save();
	}

	# sets the validation rules
	function validateWaitlistQuestionaire($questions, $progGroups) {
		// validate name (don't require middle name)
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]');
		$this->form_validation->set_rules('cMiddleName', 'Child\'s Middle Name', '');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]');

		// make sure a program was selected
		$this->form_validation->set_rules('programChecked', 'Program', 'required');

		// validate all questions on the form
		$i = 0;
		foreach ($questions as $q) {
			$this->form_validation->set_rules('q' . $i . 'answer', 'question#' . $i . '\'s answer', 'required|min_length[1]');
			$i++;
		}

		$this->form_validation->set_rules('pAgreement', 'Policy Agreement', 'required');
	}

	# Sets the validation rules for the Student Registration Form
	function validateRegistrationForm() {
		// validate name (don't require middle name)
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]');
		$this->form_validation->set_rules('cMiddleName', 'Child\'s Middle Name', '');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]');

		// make sure a program was selected
		$this->form_validation->set_rules('programChecked', 'Program', 'required');

		// verify 3 emergency contacts
		$this->form_validation->set_rules('emergencyContactName1', 'Emergency Contact#1\'s Name', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactPhone1', 'Emergency Contact#1\'s Phone', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactRelationship1', 'Emergency Contact#1\'s Relationship to child', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactName2', 'Emergency Contact#2\'s Name', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactPhone2', 'Emergency Contact#2\'s Phone', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactRelationship2', 'Emergency Contact#2\'s Relationship to child', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactName3', 'Emergency Contact#3\'s Name', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactPhone3', 'Emergency Contact#3\'s Phone', 'required|min_length[1]');
		$this->form_validation->set_rules('emergencyContactRelationship3', 'Emergency Contact#3\'s Relationship to child', 'required|min_length[1]');

		$this->form_validation->set_rules('cAddress', 'Child\'s Address', 'required|min_length[1]');
		$this->form_validation->set_rules('cPhoneNum', 'Child\s Phone', 'required|min_length[1]');
		$this->form_validation->set_rules('cBirthplace', 'Child\s birthplace', 'required|min_length[2]');
		$this->form_validation->set_rules('cDOB', 'Date of Birth', 'required|min_length[4] ');
		$this->form_validation->set_rules('cGender', 'Gender', 'required ');
		$this->form_validation->set_rules('daycareExperience', 'Daycare Experiences', 'required|min_length[1]');
		$this->form_validation->set_rules('socialExperience', 'Social Experiences', 'required|min_length[1]');
		$this->form_validation->set_rules('comfortMethod', 'Comfort your child', 'required|min_length[1]');
		$this->form_validation->set_rules('toiletNeeds', 'Toilet Needs', 'required|min_length[1]');
		$this->form_validation->set_rules('napTime', 'Takes Naps', 'required|min_length[1]');
		$this->form_validation->set_rules('playOutside', 'Plays outside', 'required|min_length[1]');
		$this->form_validation->set_rules('HasPets', 'Has Pets', 'required');
		$this->form_validation->set_rules('petType', 'Type of Pet', '');
		$this->form_validation->set_rules('petName', 'Name of Pet', '');
		$this->form_validation->set_rules('childInterestsName', 'Child\'s Interests', 'required|min_length[1]');
		$this->form_validation->set_rules('siblingOneName', 'Silbing\'s first name', 'required|min_length[1]');
		$this->form_validation->set_rules('siblingOneAge', 'Silbing\'s age', 'required|min_length[1]');
		$this->form_validation->set_rules('otherImportantInfo', 'Other Important Information', 'required|min_length[1]');
		$this->form_validation->set_rules('referenceType', 'Heard about us', 'required|min_length[1]');

		// should not be validated
		$this->form_validation->set_rules('referenceName', 'Learned About us', '');
	}

	# sets the validation rules for the MedicalInformationForm
	function validateMedicalForm() {
		$this->form_validation->set_rules('preferredHospitalName', 'Preferred Hospital', 'required|min_length[1]');
		$this->form_validation->set_rules('hospitalPhoneName', 'Hospital\'s phone number', 'required|min_length[4]');
		$this->form_validation->set_rules('physicianName', 'Physician', 'required|min_length[1]');
		$this->form_validation->set_rules('pPhoneName', 'Physician\'s Phone', 'required|min_length[12]');
		$this->form_validation->set_rules('dentistName', 'Dentist', 'required|min_length[1]');
		$this->form_validation->set_rules('dPhoneName', 'Dentist\'s Phone', 'required|min_length[12]');
		$this->form_validation->set_rules('medicalConditionsName', 'Medical Conditions', 'callback_field_exists');
		$this->form_validation->set_rules('allergiesName', 'Allergies', 'callback_field_exists');
		$this->form_validation->set_rules('insuranceCompanyName', 'Insurance Company', 'required|min_length[1]');
		$this->form_validation->set_rules('certificateNumberName', 'Insurance Certification Number', 'required|min_length[1]');
		$this->form_validation->set_rules('employerName', 'Employer', 'callback_field_exists');
	}

}
