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
		$this->data['MenuItems'] = get_menu_items('admin');
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

		// send these questions to the view for display
		$this->data['wlQuestions'] = $wlQuestions;
		
		# Set up validation for admissionsPage1.php
		$this->validateWaitlistQuestionaire($wlQuestions);
		
		// if user is posting back answers, then save the form
		if($this->form_validation->run() == TRUE) {
			// get answers from waitlist questionaire
			$this->storeWaitListForm($wlQuestions);
			
			$this->data['firstName'] = set_value('cFirstName');
			$this->data['middleName'] = set_value('cMiddleName');
			$this->data['lastName'] = set_value('cLastName');
			
			// display SUCCESS!
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admissions/forms/waitlist_success', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
		else{	
			// display the waitlist questionaire
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admissions/forms/waitlist_questionaire', $this->data);
			$this->load->view('templates/footer', $this->data);
		}
	}

	// returns all waitlisted students.
	// TODO: this functions purpose is for when we get datagrids working.
	// this method will convert the datagrid info to xml or json so that it
	// can be sent to the view and interpreted by the JQuery.
	function getWaitlistedStudents() {
		$join = 'LEFT JOIN Student s ON(WaitlistForm.FormID = s.QuestionaireID AND s.IsEnrolled != 1)';
		$wForms = Waitlist_form::all(array('joins' => $join));
		var_dump($wForms);
	}
	
	// Displays the list of all waitlisted students for the current parent.
	// TODO: filter by parent, filter out where no deposit is paid
	function registerStudentSelector() {
		$join = 'LEFT JOIN Student s ON(WaitlistForm.FormID = s.QuestionaireID AND s.IsEnrolled != 1)';
		$this->data['wlStudents'] = Waitlist_form::all(array('joins' => $join));
		
		$this->load->view('templates/header', $this->data);	
		$this->load->view('admissions/forms/register_student_selection');
		$this->load->view('templates/footer');
	}
	
	
	// Manages the register_student form. Handles displaying the
	// form, validating the form, and saving the form.
	// We are registering the student represented by the given
	// waitlist ID, wlid.
	function registerStudent($wlid = '') {
		
		// TODO: verify that this student belongs to this user
		$wlStud = Waitlist_form::find_by_formid($wlid);
		
		// populate all name info from waitlist form
		$this->data['firstName'] = $wlStud->firstname;
		$this->data['middleName'] = $wlStud->middlename;
		$this->data['lastName'] = $wlStud->lastname;
		
		# Set up validation for the student registration process
		$this->validateRegistrationForm();
		if($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $this->data);	
			$this->load->view('admissions/forms/register_student');
			$this->load->view('templates/footer');
		}
		else {
			$formData = storeRegistrationForm();
			
			// TODO: THIS MUST BE PHASED OUT
			$this->$reg->savePageOne($formData);
			
			
			// TODO: success page?
			
			// let the login controller redirect us to the appropriate dashboard
			redirect(login);	
		}
	}
	
	# saves the completed Waitlist Questionaire
	function storeWaitlistForm($questions){
		// save waitlist form to DB		
		$wlForm = new Waitlist_form();
		$wlForm->parentid = Parental::find_by_userid(user_id())->ParentID;
		$wlForm->firstname = set_value('cFirstName');
		$wlForm->middlename = set_value('cMiddleName');
		$wlForm->lastname = set_value('cLastName');
		$wlForm->agreement = set_value('pAgreement');
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
	function storeRegistrationForm() {
		$data = array(
			'cFirst' => set_value('cFirstName'),
			'cLast' => set_value('cLastName'),
			'cAddress' => set_value('cAddressName'),
			'cPhone' => set_value('cPhoneName'),
			'cityBirthplace' => set_value('cityBirthplaceName'),
			'stateBirthplace' => set_value('stateBirthplaceName'),
			'dob' => set_value('dobName'),
			'pOneFirst' => set_value('pOneFirstName'),
			'pOneLast' => set_value('pOneLastName'),
			'pOneAddress' => set_value('pOneAddressName'),
			'pOneEmail' => set_value('pOneEmailName'),
			'pOneHomePhone' => set_value('pOneHomePhoneName'),
			'pOneCellPhone' => set_value('pOneCellPhoneName'),
			'pOneBusinessPhone' => set_value('pOneBusinessPhoneName'),
			'pOneEmployer' => set_value('pOneEmployerName'),
			'pOneOccupation' => set_value('pOneOccupation'),
			'pTwoFirst' => set_value('pTwoFirstName'),
			'pTwoLast' => set_value('pTwoLastName'),
			'pTwoAddress' => set_value('pTwoAddressName'),
			'pTwoEmail' => set_value('pTwoEmailName'),
			'pTwoHomePhone' => set_value('pTwoHomePhoneName'),
			'pTwoCellPhone' => set_value('pTwoCellPhoneName'),
			'pTwoBusinessPhone' => set_value('pTwoBusinessPhoneName'),
			'pTwoEmployer' => set_value('pTwoEmployerName'),
			'pTwoOccupation' => set_value('pTwoOccupationName'),
			'daycareExperience' => set_value('daycareExperienceName'),
			'socialExperience' => set_value('socialExperienceName'),
			'comfortChild' => set_value('comfortChildName'),
			'toiletNeeds' => set_value('toiletNeedsName'),
			'napTaking' => set_value('napTakingName'),
			'playOutside' => set_value('playOutsideName'),
			'hasPets' => set_value('hasPetsName'),
			'typeOfPet' => set_value('typeOfPetName'),
			'nameOfPet' => set_value('nameOfPetName'),
			'silblingOneFirst' => set_value('silbingOneFirstName'),
			'silbingOneLast' => set_value('silbingOneLastName'),
			'silbingOneAge' => set_value('silbingOneAgeName'),
			'silbingTwoFirst' => set_value('silbingTwoFirstName'),
			'silbingTwoLast' => set_value('silbingTwoLastName'),
			'silbingTwoAge' => set_value('silbingTwoAgeName'),
			'otherImportant' => set_value('otherImportantName'),
			'hearAbout' => set_value('hearAboutName'),
			'learnedAbout' => set_value('learnedAboutName')
		);
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
	function validateWaitlistQuestionaire($questions){
		// validate name (don't require middle name)
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cMiddleName', 'Child\'s Middle Name', '');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		
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
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cAddressName', 'Child\'s Address', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cPhoneName', 'Child\s Phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cityBirthplaceName', 'City child was born in', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('stateBirthplaceName', 'State child was born in', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('dobName', 'Date of Birth', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('pOneFirstName', 'Parent\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneLastName', 'Parent\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneAddressName', 'Parent\'s Address', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneEmailName', 'Parent\'s Email Address', 'required|min_length[5]|callback_field_exists');
		$this->form_validation->set_rules('pOneHomePhoneName', 'Parent\'s home phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneCellPhoneName', 'Parent\'s cell phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneBusinessPhoneName', 'Parent\'s business phone', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneEmployerName', 'Parent\'s Employer', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pOneOccupationName', 'Parent\'s Occupation', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pTwoFirstName', 'Parent\'s First Name');
		$this->form_validation->set_rules('pTwoLastName', 'Parent\'s Last Name');
		$this->form_validation->set_rules('pTwoAddressName', 'Parent\'s Address');
		$this->form_validation->set_rules('pTwoEmailName', 'Parent\'s Email Address');
		$this->form_validation->set_rules('pTwoHomePhoneName', 'Parent\'s home phone');
		$this->form_validation->set_rules('pTwoCellPhoneName', 'Parent\'s cell phone');
		$this->form_validation->set_rules('pTwoBusinessPhoneName', 'Parent\'s business phone');
		$this->form_validation->set_rules('pTwoEmployerName', 'Parent\'s Employer');
		$this->form_validation->set_rules('pTwoOccupationName', 'Parent\'s Occupation');
		$this->form_validation->set_rules('dayCareExperienceName', 'Daycare Experiences', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('socialExperienceName', 'Social Experiences', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('comfortChildName', 'Comfort your child', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('toiletNeedsName', 'Toilet Needs', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('napTakingName', 'Takes Naps', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('playOutsideName', 'Plays outside', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('hasPetsName', 'Has Pets', 'required');
		$this->form_validation->set_rules('typeOfPetName', 'Type of Pet', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('nameOfPetName', 'Name of Pet', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('siblingOneFirstName', 'Silbing\'s first name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('silbingOneLastName', 'Silbing\'s last name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('silbingOneAgeName', 'Silbing\'s age', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('siblingTwoFirstName', 'Silbing\'s first name');
		$this->form_validation->set_rules('silbingTwoLastName', 'Silbing\'s last name');
		$this->form_validation->set_rules('silbingTwoAgeName', 'Silbing\'s age');
		$this->form_validation->set_rules('otherImportantName', 'Other Important Information', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('hearAboutName', 'Heard about us', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('learnedAboutName', 'Learned About us', 'required|min_length[1]|callback_field_exists');
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
}
