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
 * Internal library of functions for Aiken generator
 *
 * All the aikengen  specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package     tool_aikengen
 * @copyright  2016 Jamal Aruna <it@iou.edu.gm>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Checks if user has an existing file in the system
 *
 * @param int $userid
 * @return bool
 */
function tool_aikengen_user_has_aiken_file_name($userid) {
    global $DB;

    $user = $DB->record_exists('tool_aiken_filename', array('userid' => $userid));
    return $user;
}

/**
 * Checks if user owns a file
 *
 * @param int $userid
 * @param int $fileid
 * @return bool
 */
function tool_aikengen_user_own_aiken_file_id($userid, $fileid) {
    global $DB;

    $own = $DB->record_exists('tool_aiken_filename', array('userid' => $userid, 'id' => $fileid));
    return $own;
}

/**
 * Checks if user owns a question
 *
 * @param int $userid
 * @param int $fileid
 * @param int $questionid
 * @return bool
 */
function tool_aikengen_user_own_aiken_question_id($userid, $fileid, $questionid) {
    global $DB;

    $ownfile = $DB->record_exists('tool_aiken_filename', array('userid' => $userid, 'id' => $fileid));

    $ownquestion = $DB->record_exists('tool_aiken_question', array('id' => $questionid, 'fileid' => $fileid));

    $own = false;
    if ($ownfile && $ownquestion) {
        $own = true;
    }

    return $own;
}

/**
 * Get the records of files owned by a user
 *
 * @param int $userid
 * @return object
 */
function tool_aikengen_get_aiken_file_name($userid) {
    global $DB;
    $result = $DB->get_records_menu('tool_aiken_filename', array('userid' => $userid), null, 'id, filename');
    return $result;
}