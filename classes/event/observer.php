<?php
/**
 * Created by PhpStorm.
 * User: frycj
 * Date: 18/06/2018
 * Time: 14:08
 */

namespace local_personal_sandbox\event;


use local_cool\entity\config_plugin;
use local_personal_sandbox\entity\course_personal_sandbox;
use local_personal_sandbox\sandbox;

class observer
{
    public static function deleted_course(\core\event\course_deleted $course_deleted)
    {
        $entity=course_personal_sandbox::get(['courseid'=>$course_deleted->courseid]);
        if($entity==null)
            return;
        $entity->remove_from_db();
    }
    public static function changed_course(\core\event\course_updated $course_updated)
    {
        $entity=course_personal_sandbox::get(['courseid'=>$course_updated->courseid]);
        if($entity==null)
            return;

        $course=$entity->get_course();
        $realname=$entity->get_name();
        $idnumber=$entity->get_idnumber();
        $category=sandbox::get_category();

        // Id number must always match!!
        if($idnumber!=$course->get_idnumber())
            $course->set_idnumber($idnumber)->save();

        // Category must always match!!
        if($category!=$course->get_category_id())
            $course->set_category_id($category)->save();

        // Check if user can change sandbox name, if not revert changes.
        if((bool)config_plugin::get_or_create(sandbox::NAME,'change_name','false')==false)
            if($realname!=$course->get_shortname() || $realname !=$course->get_fullname()) {
                $course->set_shortname($realname)->set_fullname($realname)->save();
                \core\notification::error(get_string('notification:course_name_change_prevent',sandbox::NAME));
            }

        // Check if user can change sandbox visibility if not revert changes
        if((bool)config_plugin::get_or_create(sandbox::NAME,'change_visibility','false')==false)
            if($course->get_visibility()==1)
            {
                $course->set_visibility(0)->save();
                \core\notification::error(get_string('notification:course_visibility_change_prevent',sandbox::NAME));
            }


    }
}