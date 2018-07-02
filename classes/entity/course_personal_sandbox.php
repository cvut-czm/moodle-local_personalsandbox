<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

namespace local_personal_sandbox\entity;

defined('MOODLE_INTERNAL') || die();

use local_cool\entity\course;
use local_cool\entity\database_entity;
use local_cool\entity\user;

class course_personal_sandbox extends database_entity
{
    const TableName = 'course_personal_sandbox';

    protected $userid;
    protected $courseid;


    public static function create(int $course_id,int $user_id) : course_personal_sandbox
    {
        $entity=new course_personal_sandbox();
        $entity->courseid=$course_id;
        $entity->userid=$user_id;
        return $entity;
    }
    public function get_name() : string
    {
        return "Sandbox - {$this->get_owner()->get_fullname()}";
    }
    public function get_idnumber() : string
    {
        return 'personal_sandbox:'.$this->get_owner()->get_fullname();
    }
    public function get_owner() : user
    {
        return user::get($this->userid);
    }
    public function get_course() : course
    {
        return course::get($this->courseid);
    }
    public function get_user_id() : int
    {
        return $this->userid;
    }
    public function get_course_id() : int
    {
        return $this->courseid;
    }

}