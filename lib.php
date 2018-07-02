<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */
use \local_cool\entity\config_plugin;
function local_personal_sandbox_extend_navigation(navigation_node $navigation_node)
{
    if(config_plugin::get_or_create('local_personal_sandbox','show_in_sidebar','1')=='1'
        && has_capability('local/personal_sandbox:access',context_system::instance()))
        $navigation_node->add(
            get_string('my_sandbox','local_personal_sandbox'),
            new moodle_url('/local/personal_sandbox/my.php')
        )->showinflatnavigation=true;
}
function local_personal_sandbox_extend_navigation_course(navigation_node $parentnode, $course, $context)
{
    /*
    global $USER;
    if(\local_personal_sandbox\entity\course_personal_sandbox::exist(['userid'=>$USER->id,'courseid'=>$course->id])) {
        $node = new navigation_node(['text' => 'Sandbox settings', 'icon' => new pix_icon('i/box', ''), 'action' => new moodle_url('/local/personal_sandbox/edit.php')]);
        $node->display = true;
        $parentnode->add_node($node, 'editsettings');
    }
    */
}