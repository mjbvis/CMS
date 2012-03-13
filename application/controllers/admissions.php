<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class admissions extends Application {
			
	function __construct() {
		parent::__construct();
	
		# Load Helpers
		$this->load->helper(array('url', 'form', 'dashboard', 'ag_auth'));
		
		# Load Libraries
		
		# Load Modules
		$this->load->library('Repositories/Admissions_Repository', '', 'reg');
	}
    
    public function index()
    {
        if(logged_in())
        {
            $data = array();
            $data['title'] = 'Admin Dashboard';
    
            /* load views */
            $this->load->view('templates/header', $data);
            $this->load->view('admissions/dashboard', $data);
            $this->load->view('templates/footer', $data);
        }
        else
        {
            $this->login();
        }
    }
	
	function waitlist_questionaire() {
		// get all enabled questions
		$wlQuestions = Waitlist_question::find_all_by_enabled(1);

		// send these questions to the view for display
		$data['wlQuestions'] = $wlQuestions;
		
		# Set up validation for admissionsPage1.php
		$this->validateWaitlistQuestionaire($wlQuestions);
		
		// if user is posting back answers, then save the form
		if($this->form_validation->run() == TRUE) {
			// get answers from waitlist questionaire
			$answerData = $this->storeWaitListForm($wlQuestions);
			
			// save waitlist form to DB
			$formAttributes = array(
				'ParentID' 			=> Parental::find_by_userid(user_id())->ParentID,
				'FirstName'			=> $answerData['cFirst'],
				'MiddleName'		=> $answerData['cMiddle'],
				'LastName'			=> $answerData['cLast'],
				'Agreement'			=> 1,	//TODO: use agreement from policy form
				'SubmissionDTTM'	=> date('Y-m-d H:i:s', time()) // Example: 2012-11-28 14:32:08
			);
			$wlForm = Waitlist_form::create($formAttributes);
			
			// save each question/answer pair for this form
			$i = 0;
			foreach($wlQuestions as $q){
				$questionAttributes = array(
					'FormID'		=> $wlForm->FormID,
					'QuestionID'	=> $q->QuestionID,
					'Answer'		=> $answerData['q' . $i . 'answer']
				);
				$question_answer = Waitlist_form_question::create($questionAttributes);
				$i++;
			}
			
			// let the login controller redirect us to the appropriate dashboard
			redirect(login);
		}
		else{
			// display the waitlist questionaire
			$this->load->view('templates/header', $data);	
			$this->load->view('admissions/forms/waitlist_questionaire', $data);
			$this->load->view('templates/footer', $data);
		}
	}

	
	
	function register_page1() {
		# Set up validation for admissionsPage1.php
		$this->validatePageOne();
		if($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header');	
			$this->load->view('admissions/forms/admissionsPage1');
			$this->load->view('templates/footer');
		}
		else {
			$formData = storePageOneForm();
			$this->$reg->savePageOne($formData);
			$this->load->view('templates/header');	
			$this->load->view('admissions/forms/admissionsPage2');
			$this->load->view('templates/footer');	
		}
	}
	
	function register_page2() {
		$this->validatePageTwo();
		
		if($this->form_validation->run() == false) {
			$this->load->view('admissions/forms/admissionsPage2');
		}
		else {
			$data = storePageTwoForm();
			$this->load->view('admissions/forms/admissionsPage3');
		}	
	}
	
	function register_page3() {
		$this->form_validation->set_rules('agreementName', 'required');
		
		if($this->form_validation->run() == false) {
			$this->load->view('admissions/forms/admissionPage3');	
		}
		else {
			$data = set_value('agreementName');
			$this->load->view('admissions/forms/admissionPage4');
		}
	}	
	
	function register_page4() {
		$this->validatePageFour();
		
		if($this->form_validation->run() == false) {
			$this->load->view('admissions/forms/admissionPage4');
		}
		else {
			$data = storePageFourForm();
			$this->load->view('admissions/forms/admissionPage5');
		}
	}
	
	#region
	function storeWaitlistForm($questions){
		$data = array(
			'cFirst'		=> set_value('cFirstName'),
			'cMiddle'		=> set_value('cMiddleName'),
			'cLast'			=> set_value('cLastName')
		);
		
		// store each answer from the waitlist questionaire form
		$i = 0;
		foreach($questions as $q){
			$data['q' . $i . 'answer'] = set_value('q' . $i . 'answer');
			$i++;
		}
		
		return $data;
	}
	
	function storePageOneForm(){
		$data = array(
			'pFirst' 		=> set_value('pFirstName'),
			'pLast' 		=> set_value('pLastName'),
			'cFirst' 		=> set_value('cFirstName'),
			'cLast'		 	=> set_value('cLastName'),
			'cAge' 			=> set_value('cAgeName'),
			'dob' 			=> set_value('dobName'),
			'contactDate' 	=> set_value('contactDateName'),
			'phone' 		=> set_value('phoneName'),
			'visitDate' 	=> set_value('visitDateName'),
			'email'		 	=> set_value('emailName'),
			'learnedAbout'  => set_value('learnedAboutName'),
			'adIn'			=> set_value('adInName'),
			'other'			=> set_value('otherName'),
			'interest'		=> set_value('interestName'),
			'understanding' => set_value('understandingName'),
			'willingness'	=> set_value('willingnessName'),
			'movingCity'	=> set_value('movingCityName'),
			'movingState'	=> set_value('movingStateName'),
			'movingSchool'	=> set_value('movingSchoolName'),
			'learningNotes' => set_value('learningNotesName'),
			'montessoriImp' => set_value('montessoriImpressionsName'),
			'interviewImp'	=> set_value('interviewImpressionsName'),
			'obervationDate'=> set_value('observationDateName'),
			'classroom'		=> set_value('classroomName'),
			'attended'  	=> set_value('attendedName'),
			'onTime'		=> set_value('onTimeName'),
			'interviewDate' => set_value('interviewDateName'),
			'appReceived' 	=> set_value('appReceivedName'),
			'feeReceived'	=> set_value('feeReceivedName')
		);
		return $data;
	}

	function storePageTwoForm() {
		$data = array(
			'cFirst' => set_value('cFirstName'),
			'cLast' => set_value('cLastName'),
			'currentDate' => set_value('currentDateName'),
			'qOne' => set_value('qOneName'),
			'qTwo' => set_value('qTwoName'),
			'qThree' => set_value('qThreeName'),
			'qFour' => set_value('qFourName'),
			'qFive' => set_value('qFiveName'),
			'qSix' => set_value('qSixName'),
			'qSeven' => set_value('qSevenName'),
			'qEight' => set_value('qEightName'),
			'qNine' => set_value('qNineName'),
			'qTen' => set_value('qTenName'),
			'qEleven' => set_value('qElevenName'),
			'qTwelve' => set_value('qTwelveName'),
			'qThirteen' => set_value('qThirteenName'),
			'qFourteen' => set_value('qFourteenName'),
			'qFifteen' => set_value('qFifteenName'),
			'qSixteen' => set_value('qSixteenName')
		);
	}
	
	function storeFormPageFour() {
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

	function storeFormPageFive() {
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

	function validateWaitlistQuestionaire($questions){
		// validate name (don't require middle name)
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		
		// validate all questions on the form
		$i = 0;
		foreach($questions as $q){
			$this->form_validation->set_rules('q' . $i . "answer", 'Question ' . $i . ' answer', 'required|min_length[1]|callback_field_exists');
			$i++;
		}
	}

	function validatePageOne(){
		$this->form_validation->set_rules('pFirstName', 'Parent\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pLastName', 'Parent\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cAgeName', 'Child\'s Age', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('dobName', 'Date of Birth', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('contactDateName', 'Contact Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('phoneName', 'Phone Number', 'required|min_length[10]|callback_field_exists');
		$this->form_validation->set_rules('visitDateName', 'Visit Date', 'required|min_length[10]|callback_field_exists');
		$this->form_validation->set_rules('emailName', 'Email', 'required|min_length[5]|callback_field_exists');
		$this->form_validation->set_rules('learnedAboutName', 'Learned About CMS How', 'required');
		$this->form_validation->set_rules('interestName', 'Level of Interest', 'required');
		$this->form_validation->set_rules('understandingName', 'Understanding of Montessori', 'required');
		$this->form_validation->set_rules('willingnessName', 'Willingness to learn more', 'required');
		$this->form_validation->set_rules('movingCityName', 'Moving City', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('movingStateName', 'Moving State', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('movingSchoolName', 'Moving School', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('montessoriImpressionsName', 'Montessori Impressions', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('interviewImpressionsName', 'Interviews Impressions', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('observationDateName', 'Classroom Obersvation Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('classroomName', 'Classroom Observed', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('attendedName', 'Attended', 'required');
		$this->form_validation->set_rules('onTimeName', 'On Time', 'required');
		$this->form_validation->set_rules('interviewDateName', 'Interview Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('appReceivedName', 'Date Application Received', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('feeReceivedName', 'Date Application Fee Received', 'required|min_length[4]|callback_field_exists');
	}
	
	function validatePageTwo() {
		$this->form_validation->set_rules('cFirstName', 'Child\'s First Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('cLastName', 'Child\'s Last Name', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('pgTwoCurrentDateName', 'Current Date', 'required|min_length[4]|callback_field_exists');
		$this->form_validation->set_rules('qOneName', 'Question 1', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qTwoName', 'Question 2', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qThreeName', 'Question 3', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qFourName', 'Question 4', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qFiveName', 'Question 5', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qSixName', 'Question 6', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qSevenName', 'Question 7', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qEightName', 'Question 8', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qNineName', 'Question 9', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qTenName', 'Question 10', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qElevenName', 'Question 11', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qTwelveName', 'Question 12', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qThirteenName', 'Question 13', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qFourteenName', 'Question 14', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qFifteenName', 'Question 15', 'required|min_length[1]|callback_field_exists');
		$this->form_validation->set_rules('qSixteenName', 'Question 16', 'required|min_length[1]|callback_field_exists');
	}

	function validatePageFour() {
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

	function validatePageFive() {
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
