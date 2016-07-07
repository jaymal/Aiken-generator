<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    tool
 * @package aikengen
 * @copyright  2016 Jamal Aruna <it@iou.edu.gm> 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../../config.php');
//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");
require_once($CFG->dirroot.'/admin/tool/aikengen/locallib.php');

class entry_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG,$DB,$USER;
 					   	     
 					   	      					   			   	 					 				    			     					
        $mform = $this->_form; // Don't forget the underscore! 
        $mform->addElement('header', 'enterthequestion',get_string('enterthequestion',TOOL_AIKENGEN_LANG), '');
        $mform->addElement('hidden', 'id', null,'ng-model="id"');
        $mform->setType('id', PARAM_INT);
          
        $mform->addElement('textarea', 'full_questiontext',get_string('questiontext',TOOL_AIKENGEN_LANG), 'wrap="virtual" rows="10" cols="50" ng-model="full_questiontext"');
        $mform->setType('full_questiontex', PARAM_TEXT);

		$mform->addElement('header', 'filloption', get_string('filloption',TOOL_AIKENGEN_LANG), '');
        $mform->addElement('text', 'option_a',get_string('option_a',TOOL_AIKENGEN_LANG), 'size="80" ng-model="option_a"');
        $mform->setType('option_a', PARAM_TEXT);
        
        $mform->addElement('text', 'option_b',get_string('option_b',TOOL_AIKENGEN_LANG), 'size="80" ng-model="option_b"');
        $mform->setType('option_b', PARAM_TEXT);
        
        $mform->addElement('text', 'option_c',get_string('option_c',TOOL_AIKENGEN_LANG), 'size="80" ng-model="option_c"');
        $mform->setType('option_c', PARAM_TEXT);
        
        $mform->addElement('text', 'option_d',get_string('option_d',TOOL_AIKENGEN_LANG),'size="80" ng-model="option_d"');
        $mform->setType('option_d', PARAM_TEXT);
     
        $mform->addElement('text', 'option_e',get_string('option_e',TOOL_AIKENGEN_LANG), 'size="80" ng-model="option_e"');
        $mform->setType('option_e', PARAM_TEXT);
        
        $mform->addElement('header', 'answerhead', get_string('answerhead',TOOL_AIKENGEN_LANG), '');
		$answer = array("A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E");
		$default_answer[''] = 'Select one';
        
        $answer = array_merge($default_answer, $answer);
        $mform->addElement('select', 'correct_answer', 'Choose the Answer', $answer,'ng-model="correct_answer"');
         $mform->setType('correct_answer', PARAM_TEXT);
		$mform->setDefault('correct_answer',null);
	
		$mform->addElement('header', 'filenameheader', get_string('filenameheader',TOOL_AIKENGEN_LANG), '');
		//$answer = array("A"=>"A","B","C","D","E");
		$filenames = get_aiken_file_name($USER->id);
		$default_file[''] = 'Choose one';
        
        //$filenames = array_merge($default_file, $filenames); 
        //array_merge does not preserve numeric keys which we need to be preserved so we use union operator instead
        $filenames = $default_file + $filenames;
        $mform->addElement('select', 'filename', 'Choose the filename', $filenames ,'ng-model="filename"');
        $mform->setType('filename', PARAM_INT);
		$mform->setDefault('filename',null);
      
       
        $this->add_action_buttons();
       
    }
   
   
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}



class filename_drop_menu_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG,$DB,$USER;
		$mform = $this->_form; // Don't forget the underscore! 			   	      
		$filenames = get_aiken_file_name($USER->id);
		$default_file[''] = get_string('choosefiletodownload',TOOL_AIKENGEN_LANG);

        //array_merge does not preserve numeric keys which we need to be preserved so we use union operator instead
        $filenames = $default_file + $filenames;
        $mform->addElement('select', 'filedload', '', $filenames ,'ng-model="fileid_dload"');
        $mform->setType('filedload', PARAM_INT);
		$mform->setDefault('filedload',null);
       
       }
     //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
} 


class viewfile_drop_menu_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG,$DB,$USER;
		mform = $this->_form; // Don't forget the underscore! 			   	      
		$filenames = get_aiken_file_name($USER->id);
		$default_file[''] =  get_string('choosefiletoview',TOOL_AIKENGEN_LANG);

        //array_merge does not preserve numeric keys which we need to be preserved so we use union operator instead
        $filenames = $default_file + $filenames;
        $mform->addElement('select', 'fileview', '', $filenames ,'ng-model="viewfileid", ng-change="change({{viewfileid}})"');
        $mform->setType('fileview', PARAM_INT);
		$mform->setDefault('fileview',null);
       
       }
     //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
} 