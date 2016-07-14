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
 * Filenames are created here before questions are added
 * @package     tool_aikengen
 * @copyright  2016 Jamal Aruna <it@iou.edu.gm>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../../config.php');
require_login();
require_capability('tool/aikengen:view', context_system::instance());

require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/tag/lib.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot .'/lib/moodlelib.php');
require_once($CFG->libdir .'/pagelib.php');
require_once('classes/filename_form.php');
require_once('lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('course');
$PAGE->set_title($SITE->fullname.': Aiken generator ' );
$PAGE->navbar->add('Aiken generator');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_url($CFG->wwwroot.'/admin/tool/aikengen/index.php');

$PAGE->requires->js(new moodle_url('js/angular.min.js'), true);
$PAGE->requires->js(new moodle_url('js/jquery-3.0.0.min.js'), true);


$sesskey = optional_param('sesskey', '__notpresent__', PARAM_RAW);

$fileform = new filename_form(null, null, null, null, 'ng-submit="insertdata()"');
if ($fileform->is_cancelled()) {
    $returnurl = new moodle_url('index.php');
    redirect($returnurl);

} else if ($fromform = $fileform->get_data()) {

    if (!confirm_sesskey($sesskey)) {

        $PAGE->set_title($SITE->fullname);
        $PAGE->set_heading($SITE->fullname);
        echo $OUTPUT->header();
        echo $OUTPUT->confirm(get_string('logoutconfirm'), new moodle_url($PAGE->url,
                array('sesskey' => sesskey())), $CFG->wwwroot.'/');
        echo $OUTPUT->footer();
        die;
    }
    $record = new stdClass();
    $record->userid = $USER->id;
    $record->filename = $fromform->filename;
    $recordentered = $DB->insert_record('tool_aiken_filename', $record);


    if ($recordentered) {
        $nexturl = new moodle_url('view.php');
        redirect($nexturl);
    } else {
        echo "Unable to submit form";
        exit;

    }
}
echo $OUTPUT->header();
$fileform->display();

echo $OUTPUT->footer();
