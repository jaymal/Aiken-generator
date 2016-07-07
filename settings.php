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
 * @subpackage aikengen
 * @copyright  2016 Jamal Aruna 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

//$ADMIN->add('courses', new admin_externalpage('tool_aikengen', get_string('pluginname', 'tool_aikengen'), "$CFG->wwwroot/$CFG->admin/tool/aikengen/index.php", 'tool/aikengen:view'));

$ADMIN->add('root', new admin_category('aikengen', 'Aiken Generator'));
$ADMIN->add('aikengen', new admin_externalpage('tool_aikengen', get_string('createfile', 'tool_aikengen'),
            "$CFG->wwwroot/$CFG->admin/tool/aikengen/index.php"));
$ADMIN->add('aikengen', new admin_externalpage('toolaikengen', get_string('editfile', 'tool_aikengen'),
            "$CFG->wwwroot/$CFG->admin/tool/aikengen/view.php"));