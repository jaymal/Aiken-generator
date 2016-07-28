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
 * Form class definition for adding filenames
 * @package    tool_aikengen
 * @copyright  2016 Jamal Aruna <it@iou.edu.gm>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Moodleform is defined in formslib.php.
require_once("$CFG->libdir/formslib.php");

/**
 * This class defines the form for adding filenames
 *
 * @copyright 2016 Jamal Aruna
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_aikengen_filename_form extends moodleform {
    /**
     * This method adds elements to the form
     */
    public function definition() {
        global $CFG, $DB, $USER;
        $mform = $this->_form; // Don't forget the underscore!.
        $mform->addElement('header', 'filenameheader', get_string('enterthefilename', TOOL_AIKENGEN_LANG), '');

        $mform->addElement('text', 'filename', get_string('enterfilename', TOOL_AIKENGEN_LANG), 'size="80" ng-model="filename"');
        $mform->setType('filename', PARAM_NOTAGS);
        $mform->addRule('filename', 'File Name is required', 'required', null, 'server');

        $this->add_action_buttons();

        $mform->addElement('static', 'editexisting', '', '<a href="view.php" '
                . 'onclick="this.target=\'_blank\'">Click here to edit an existing filename.</a>');
    }



    /**
     * Custom validation should be added here.
     */
    public function validation($data, $files) {
        return array();
    }
}