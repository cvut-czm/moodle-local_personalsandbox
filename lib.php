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

use \local_cool\entity\config_plugin;

function local_personal_sandbox_extend_navigation(navigation_node $navigation_node) {
    if (config_plugin::get_or_create('local_personal_sandbox', 'show_in_sidebar', '1') == '1'
            && has_capability('local/personal_sandbox:access', context_system::instance())) {
        $navigation_node->add(
                get_string('my_sandbox', 'local_personal_sandbox'),
                new moodle_url('/local/personal_sandbox/my.php')
        )->showinflatnavigation = true;
    }
}

function local_personal_sandbox_extend_navigation_course(navigation_node $parentnode, $course, $context) {
    /*
    global $USER;
    if(\local_personal_sandbox\entity\course_personal_sandbox::exist(['userid'=>$USER->id,'courseid'=>$course->id])) {
        $node = new navigation_node(['text' => 'Sandbox settings', 'icon' => new pix_icon('i/box', ''), 'action' => new moodle_url('/local/personal_sandbox/edit.php')]);
        $node->display = true;
        $parentnode->add_node($node, 'editsettings');
    }
    */
}