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

/**
 * Internal library of functions for Aiken generator
 *
 * All the Centers specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    Aiken generator
 * @copyright  COPYRIGHTNOTICE
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Jamal Aruna it@iou.edu.gm
 */

function user_has_aiken_file_name($userid) {
	global $DB;
	
	$user = $DB->record_exists('tool_aiken_filename', array('userid'=>$userid));
    	return $user ;
}

function user_own_aiken_file_id($userid,$fileid) {
	global $DB;
	
	$own = $DB->record_exists('tool_aiken_filename', array('userid'=>$userid,'id'=>$fileid));
    	return $own ;
}

function get_aiken_file_name($userid) {
	global $DB;
	$result = $DB->get_records_menu('tool_aiken_filename', array('userid'=>$userid),null,'id,filename');
    	return $result;
}