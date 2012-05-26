<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interview_observation_form extends ActiveRecord\Model
{
	# explicit table name
	static $table_name = 'ProspectInterview';
	
	# explicit pk since our pk is not "id" 
 	//static $primary_key = 'ProspectID';
	
	# explicit column names for the sake of readability
	static $alias_attribute = array(
		'ProspectID' => 'ProspectID',
		'ParentNames' => 'ParentNames',
		'ChildrenNamesAges' => 'ChildrenNamesAges',
		'FirstContactedDTTM' => 'FirstContactedDTTM',
		'InterviewDTTM' => 'InterviewDTTM',
		'PhoneNumber' => 'PhoneNumber',
		'Email' => 'Email',
		'MontessoriImpressions' => 'MontessoriImpressions',
		'InterviewImpressions' => 'InterviewImpressions',
		'LevelOfInterest' => 'LevelOfInterest',
		'LevelOfUnderstanding' => 'LevelOfUnderstanding',
		'WillingnessToLearn' => 'WillingnessToLearn',
		'IsLearningIndependently' => 'IsLearningIndependently',
		'IsLearningAtOwnPace' => 'IsLearningAtOwnPace',
		'IsHandsOnLearner' => 'IsHandsOnLearner',
		'IsMixedAges' => 'IsMixedAges',
		'WebSearchRef' => 'WebSearchRef',
		'CMSFamilyRef' => 'CMSFamilyRef',
		'FriendsRef' => 'FriendsRef',
		'AdRef' => 'AdRef',
		'AddRefNote' => 'AdRefNote',
		'OtherRef' => 'OtherRef',
		'OtherRefNote' => 'OtherRefNote',
		'ReferenceNotes' => 'ReferenceNotes',
		'NewCityState' => 'NewCityState',
		'NewSchool' => 'NewSchool',
		'ObservationDTTM' => 'ObservationDTTM',
		'ClassID' => 'ClassID',
		'AttendedObservation' => 'AttendedObservation',
		'OnTimeToObservation' => 'OnTimeToObservation',
		'AppReceivedDTTM' => 'AppReceivedDTTM',
		'FeeReceivedDTTM' => 'FeeReceivedDTTM');
}
	static $belongs_to = array(
		array('classroom'
			 ,'class_name' => 'Classroom'
			 ,'foreign_key' => 'classid'
			 ,'primary_key' => 'classid')
		);
	
?>