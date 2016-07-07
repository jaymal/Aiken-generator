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
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/tag/lib.php');
require_once($CFG->dirroot .'/course/lib.php');
require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot .'/lib/moodlelib.php');
require_once($CFG->libdir .'/pagelib.php');
require_once('classes/entry_form.php');
require_once('/lib.php');
require_once('locallib.php');

require_login();
require_capability('tool/aikengen:view', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('base');
$PAGE->set_title($SITE->fullname.': Aiken generator ' );
$PAGE->navbar->add('Aiken generator');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_url($CFG->wwwroot.'/admin/tool/aikengen/index.php');

//custom stylesheet
$PAGE->requires->css(new moodle_url('styles.css'));
//$PAGE->requires->css(new moodle_url('css/bootstrap.css'));
//custom js files
$PAGE->requires->js(new moodle_url('js/angular.min.js'),true);//true includes at header,its removal makes it load at the footer
$PAGE->requires->js(new moodle_url('js/jquery-3.0.0.min.js'),true);

if (!user_has_aiken_file_name($USER->id)){
	$message = "You do not have an exisiting filename.Please create one first before you can add questions";
	$returnurl =  new moodle_url('index.php');
    //redirect($returnurl,$message,5);

}


echo $OUTPUT->header();

?>
<div class="container">
	<div class="row">
		<div  ng-app="myApp" ng-controller="aikenctrl">
					
			<div class="col-md-6">


				<?php
				//$payform = new entry_form('action',null_aray(form parameters),'method','target','ng-submit="insertdata()"');

				$qform = new entry_form(null,null,null,null,'ng-submit="insertdata()",name="entryForm"');
				$toform='';
				$qform->set_data($toform);
				$qform->display();

				?>
				{{successMessage}}
			</div>

			<div class="col-md-6" id="updated" >
				 <h3> <?php echo get_string('liveupdates',TOOL_AIKENGEN_LANG); ?> </h3>
				 <div class="col-md-12">
							<?php 
								$fileview = new viewfile_drop_menu_form();
								$toform='';
								$fileview->set_data($toform);
								$fileview->display();
							?>
							 </div>
				 <div class="live-update">
					<table class="generaltable">
					   <tbody>
						<tr ng-repeat = "item in data">
								<td class="cell c{{$index}}" style="">{{$index+1}} - {{item.question}} <br>
									A: {{item.option_a}}<br>
									B: {{item.option_b}}<br>
									C: {{item.option_c}}<br>
									D: {{item.option_d}}<br>
									E: {{item.option_e}}<br>
									Answer: {{item.answer}}<br><br>
									<button ng-click="deleteQuestion(item.id,item.fileid)">Delete</button>
									<button ng-click="editQuestion(item.id,item.question,item.option_a,item.option_b,item.option_c,
									item.option_d,item.option_e,item.answer,item.fileid)">Edit</button>
								</td>
						</tr>
					   </tbody>
					</table>
				
				</div>
				<hr />	 	
							<div class="col-md-8">
								<?php 
									$fileform = new filename_drop_menu_form();
									$toform='';
									$fileform->set_data($toform);
									$fileform->display();
								?>
							 </div>
							  <div class="col-md-4">
								  <a href="download_question.php?fileid={{fileid_dload}}">
										<button><?php echo get_string('downloadfile',TOOL_AIKENGEN_LANG); ?></button>
								  </a>
							</div> 
							
			</div>
  <!-- app js --> 
  <script src="js/jquey-app.js"></script>
  <script src="js/app.js"></script>
  

		</div>
	</div>
</div>
<?php

echo $OUTPUT->footer();
?>