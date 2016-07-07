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


defined('MOODLE_INTERNAL') || die();

/**
 * A custom renderer class that extends the plugin_renderer_base.
 *
 * @package tool_aikengen
 * @copyright 2016 Jamal Aruna
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_aikengen_renderer extends plugin_renderer_base {


    /**
     * Returns the instructions for the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_entry_form() {
    	$html =  $this->output->box_start();
		$qform = new entry_form(null,null,null,null,'ng-submit="insertdata()"');
		$toform='';
		$qform->set_data($toform);
    	$html .=  html_writer::div($qform->display());
		$html .= html_writer::start_span('') . '{{successMessage}}' . html_writer::end_span();
    	$html .=  $this->output->box_end();
    	return $html;
    }
	
 public function fetch_live_updates_section() {
    	$html =  $this->output->box_start();
    	$liveupdatecontent = html_writer::tag('h3',get_string('liveupdates',TOOL_AIKENGEN_LANG)); 
		
		//set up the view file dropdown
		$fileview = new viewfile_drop_menu_form();
		$toform='';
		$fileview->set_data($toform);
		$liveupdatecontent .= $fileview->display();
		
    	$html .=  html_writer::div($entry_form, 'col-md-6');
		$html .= html_writer::start_span('') . '{{successMessage}}' . html_writer::end_span();
		
    	$html .=  $this->output->box_end();
    	return $html;
    }






























	/**
     * Returns the header for the module
     *
     * @param mod $instance
     * @param string $currenttab current tab that is shown.
     * @param int    $item id of the anything that needs to be displayed.
     * @param string $extrapagetitle String to append to the page title.
     * @return string
     */
    public function header($moduleinstance, $cm, $currenttab = '', $itemid = null, $extrapagetitle = null) {
        global $CFG;

        $activityname = format_string($moduleinstance->name, true, $moduleinstance->course);
        if (empty($extrapagetitle)) {
            $title = $this->page->course->shortname.": ".$activityname;
        } else {
            $title = $this->page->course->shortname.": ".$activityname.": ".$extrapagetitle;
        }

        // Build the buttons
        $context = context_module::instance($cm->id);

    /// Header setup
        $this->page->set_title($title);
        $this->page->set_heading($this->page->course->fullname);
        $output = $this->output->header();

        if (has_capability('mod/pairwork:manage', $context)) {
          if (!empty($currenttab)) {
                ob_start();
                include($CFG->dirroot.'/mod/pairwork/tabs.php');
                $output .= ob_get_contents();
                ob_end_clean();
            }
        } else {
            $output .= $this->output->heading($activityname);
        }

        return $output;
    }
	
	/**
     * Return HTML to display limited header
     */
      public function notabsheader(){
      	return $this->output->header();
      }
      
         /**
     * Returns the instructions for the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_view_instructions() {
    	$html =  $this->output->box_start();
    	$instructions = get_string('view_instructions','pairwork');
    	$html .=  html_writer::div($instructions,MOD_PAIRWORK_CLASS . '_instructions');
    	$html .=  $this->output->box_end();
    	return $html;
    }
    
    /**
     * Returns the buttons at the bottom of the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_view_buttons() {

    	$a_url =  new moodle_url('/mod/pairwork/activity.php',array('id'=>$this->page->cm->id,'partnertype'=>'a'));
    	$b_url =  new moodle_url('/mod/pairwork/activity.php',array('id'=>$this->page->cm->id,'partnertype'=>'b'));
    	$html = $this->output->single_button($a_url,get_string('partnera',MOD_PAIRWORK_LANG));
    	$html .= $this->output->single_button($b_url,get_string('partnerb',MOD_PAIRWORK_LANG));
    	return html_writer::div($html,MOD_PAIRWORK_CLASS . '_buttoncontainer');
    }

    /**
     * Returns the buttons at the bottom of the view page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_view_userreport_button() {
        $userreport_url =   new moodle_url('/mod/pairwork/userreport.php',
            array('id'=>$this->page->cm->id));
        $html = $this->output->single_button($userreport_url,
            get_string('userreport',MOD_PAIRWORK_LANG));
        return html_writer::div($html,MOD_PAIRWORK_CLASS . 'userreport_buttoncontainer');
    }



    /**
     * Returns the header for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_header($moduleinstance,$displayopts) {
	    $html = $this->output->heading($moduleinstance->name, 2, 'main');
        $html .= $this->output->heading(get_string('student_x',MOD_PAIRWORK_LANG ,strtoupper($displayopts->partnertype)), 3, 'main');
        return $html;
    }
     /**
     * Returns the instructions for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_instructions($moduleinstance,$displayopts) {
    	$html =  $this->output->box_start();
        //$instructions = get_string('defaultinstructions',MOD_PAIRWORK_LANG);
    	if($displayopts->partnertype=='a'){
    		$instructions =$moduleinstance->instructionsa;
    	}else{
    		$instructions =$moduleinstance->instructionsb;
    	}
		$contextid = $this->page->context->id;
		$instructions = file_rewrite_pluginfile_urls($instructions,'pluginfile.php', $contextid, 
    'mod_pairwork', 'instructions' . $displayopts->partnertype, $moduleinstance->id); 
    	$html .=  html_writer::div($instructions,MOD_PAIRWORK_CLASS . '_instructions');
    	$html .=  $this->output->box_end();
    	return $html;
    }
     /**
     * Returns the picture resource for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_resource($moduleinstance,$displayopts) {
    	global $CFG;
    	
    	//$this->page->requires->js_call_amd('mod_pairwork/togglebutton','init');
    	//$this->page->requires->js_call_amd('mod_pairwork/ouch','init');
    	$this->page->requires->js_init_call('M.mod_pairwork.togglebutton.init');
    	$this->page->requires->js_init_call('M.mod_pairwork.ouch.init');
    	
    	//establish rol
    	if($displayopts->partnertype=='a'){
    		$myrole = 'a';
    		$partnerrole='b';
    	}else{
    		$myrole='b';
    		$partnerrole='a';
    	}
    	//get mypicture
    	$mypicture =  html_writer::img($CFG->wwwroot . '/mod/pairwork/resource/picture_' . $myrole . '.gif',
    		'my picture',array('class'=>MOD_PAIRWORK_CLASS . '_'  . 'resource'));
    	$mypicture = html_writer::div($mypicture, MOD_PAIRWORK_CLASS . '_resourcecontainer');
    	//get partnerpicture
    	$partnerpicture = html_writer::img($CFG->wwwroot . '/mod/pairwork/resource/picture_' . $partnerrole . '.gif',
    		'partner picture',array('class'=>MOD_PAIRWORK_CLASS . '_'  . 'resource mod_pairwork_partnerpic'));
    		
    	$partnerpicture = html_writer::div($partnerpicture, 
    		MOD_PAIRWORK_CLASS . '_resourcecontainer ' . MOD_PAIRWORK_CLASS . '_partnerpiccontainer hide');
		
		//show mypicture , and maybe partner picture
		$html = $mypicture;
    //	if($displayopts->seepartnerpic){
    		$html .= '<br/>' . $partnerpicture;
    //	}
    	return $html;
    }
	 /**
     * Returns the buttons at the bottom of the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_activity_buttons($moduleinstance,$displayopts) {
    	
    	//if showhide is false
    	if(!$moduleinstance->showhide){return '';}
    	
    	$partnerpic_visible = $displayopts->seepartnerpic;
    	$pageurl = $this->page->url;
    	$pageurl->params(array('seepartnerpic'=>!($partnerpic_visible),'partnertype'=>$displayopts->partnertype));
    	$actionlabel = get_string('see',MOD_PAIRWORK_LANG);
    	if($partnerpic_visible){$actionlabel = get_string('hide',MOD_PAIRWORK_LANG);}
    	
    	$button = new single_button($pageurl,$actionlabel . get_string('partnerpic',MOD_PAIRWORK_LANG));
    	//$button->add_confirm_action('Do you really want to ' . $actionlabel .' your partners picture?');
    	$buttonhtml = $this->render($button);
    	
    	$togglebutton = html_writer::tag('button',get_string('partnerpic',MOD_PAIRWORK_LANG),
    		array('class'=>MOD_PAIRWORK_CLASS . '_togglebutton btn btn-primary'));
    		
    	return html_writer::div( $togglebutton,MOD_PAIRWORK_CLASS . '_'  . 'buttons');
    }


    /**
     * Returns the header for the activity page
     *
     * @param object $instance
     * @param object $displayopts
     * @return string
     */
    public function fetch_userreport_header($moduleinstance,$displayopts) {
        $html = $this->output->heading($moduleinstance->name, 2, 'main');
        $html .= $this->output->heading(get_string('userreport',MOD_PAIRWORK_LANG), 3, 'main');
        return $html;
    }

    public function fetch_userreport_buttons($moduleinstance,$displayopts)
    {
        $html = '';

        //back button
        $backurl = $this->page->url;
        $hasback = $displayopts->currentpage > 1;
        if ($hasback) {
            $backurl->params(array('currentpage' => $displayopts->currentpage - 1, 'sort' => $displayopts->sort));
            $html .= $this->output->single_button($backurl,get_string('back'));
        }
        //next button
        $nexturl = $this->page->url;
        $hasnext = $displayopts->usercount > ($displayopts->currentpage * $displayopts->perpage);
        if ($hasnext) {
            $nexturl->params(array('currentpage' => $displayopts->currentpage + 1, 'sort' => $displayopts->sort));
            $html .= $this->output->single_button($nexturl,get_string('next'));
        }
        return html_writer::div($html,MOD_PAIRWORK_CLASS . '_userreport_buttoncontainer');
    }

	public function fetch_user_list($moduleinstance, $userdata, $displayopts)
	{
		//set up display fields
		$fields = array('username','firstname','lastname','email');

		//set up our table and head attributes
		$tableattributes = array('class'=>'table table-striped usertable '. MOD_PAIRWORK_CLASS .'_table');
		$headrow_attributes = array('class'=>'success ' . MOD_PAIRWORK_CLASS . '_userreport_headrow');


		$htmltable = new html_table();
		$htmltable->attributes = $tableattributes;


		$htr = new html_table_row();
		$htr->attributes = $headrow_attributes;
		foreach($fields as $field){
            $cellurl = $this->page->url;
            $usesort = $field . ' ASC';
            if($displayopts->sort==$usesort){
                $usesort = $field . ' DESC';
            }
            $cellurl->params(array('sort'=>$usesort));
			$htr->cells[]=new html_table_cell(html_writer::link($cellurl,get_string($field)));
			//$htr->cells[]=new html_table_cell(get_string($field));
		}
		$htmltable->data[]=$htr;

		foreach($userdata as $row){
			$htr = new html_table_row();
			//set up descrption cell
			$cells = array();
			foreach($fields as $field){
				$cell = new html_table_cell($row->{$field});
				$cell->attributes= array('class'=>MOD_PAIRWORK_CLASS . '_userreport_cell_' . $field);
				$htr->cells[] = $cell;
			}

			$htmltable->data[]=$htr;
		}
		$html = html_writer::table($htmltable);
		return $html;

	}
    /**
     *
     */
    public function show_something($showtext) {
		$ret = $this->output->box_start();
		$ret .= $this->output->heading($showtext, 4, 'main');
		$ret .= $this->output->box_end();
        return $ret;
    }

	 /**
     *
     */
	public function show_intro($pairwork,$cm){
		$ret = "";
		if (trim(strip_tags($pairwork->intro))) {
			$ret .= $this->output->box_start('mod_introbox');
			$ret .= format_module_intro('pairwork', $pairwork, $cm->id);
			$ret .= $this->output->box_end();
		}
		return $ret;
	}
  
}
