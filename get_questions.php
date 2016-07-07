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
 * read questions into the table
 *
 **/
require_once('../../../config.php');
require_once('locallib.php');
require_login();
global $DB;

$fileid = required_param('fileid', PARAM_INT);
$admin='';
if (user_own_aiken_file_id($USER->id,$fileid) || $admin){
	
	$query = "Select * from mdl_tool_aiken_question where fileid = ?";
	$records = $DB->get_records_sql($query,array($fileid));
	foreach($records as $row){
	 	
	 	$data[] = $row;
	 
	 }
	
	 print json_encode($data);

}
else{
	print_error("noviewpermission",'tool_aikengen');	
	//redirect(new moodle_url($PAGE->url)); //shouldnt happen though

}
?>