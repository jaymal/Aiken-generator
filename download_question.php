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
 *Downloads questions from the table in aiken format
 *
 **/
 
require_once('../../../config.php');
require_once('locallib.php');
require_login();
global $DB;

$fileid = required_param('fileid', PARAM_INT);
if(!$fileid){
	print_error("chooseafilenamefordownload",'tool_aikengen');	
	exit;
}
//if(has_capability('tool/aikengen:view',context_system::instance())){

if (user_own_aiken_file_id($USER->id,$fileid)){

	$filename = "aiken_".$fileid;
	$records = $DB->get_records('c_aiken_question', array('fileid'=>$fileid));
	foreach($records as $row){
	 	
	 	$line .= $row->question."\n";
	 	$line .= "A) ".$row->option_a."\n";
	 	$line .= "B) ".$row->option_b."\n";
	 	$line .= "C) ".$row->option_c."\n";
	 	$line .= "D) ".$row->option_d."\n";
	 	$line .= "E) ".$row->option_e."\n";
	 	$line .= "ANSWER: ".$row->answer."\n";
	 	$line .= "\n";
	
	 
	 }
}
else{
	print_error("nodownloadpermission",'tool_aikengen');	
	//redirect(new moodle_url($PAGE->url)); //shouldnt happen though

}
?>
<?
// Send file headers
/*
 $handle = fopen("aikenfile.txt", "w");
    fwrite($handle, $line);
    fclose($handle);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('aikenfile.txt'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('aikenfile.txt'));
    readfile('aikenfile.txt');
    exit;
*/

header("Content-type: text/plain; charset=utf-8");
header("Content-Disposition: attachment;filename={$filename}.txt");
header("Content-Transfer-Encoding: binary"); 
header('Pragma: no-cache'); 
header('Expires: 0');
echo "$line";

?>