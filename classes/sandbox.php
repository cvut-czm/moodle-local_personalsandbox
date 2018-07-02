<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

namespace local_personal_sandbox;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

use local_cool\entity\course_category;
use local_cool\entity\role;
use local_cool\entity\user;
use local_cool\todo;
use local_personal_sandbox\entity\course_personal_sandbox;

class sandbox
{
    public const NAME='local_personal_sandbox';
    /**
     * Method for resolving user from username,user_id, entity class or stdClass.
     *
     * Fallback with hard cast to int if object is neither of this types.
     *
     * @param  \stdClass|user|int|string $user Inputed user
     * @return int ID of user
     * @throws \dml_exception Should not happen, it would mean problem with DB connection itself.
     */
    private static function resolve_user($user) : int
    {
        if(is_string($user))
            $user=user::get_field(['username'=>$user],'id');
        else if($user instanceof user)
            $user=$user->get_id();
        else if($user instanceof \stdClass)
            /** @var \stdClass $user */
                $user=$user->id;
        return (int)$user;
    }

    /**
     * Return category of personal sandboxes
     *
     * If category doesn´t exists it is automatically created.
     *
     * @return int ID of category
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public static function get_category() : int
    {
        if(!course_category::exist(['idnumber'=>'personal_sandbox'])) {
            $data = [
                'name' => 'Personal sandboxes',
                'idnumber' => 'personal_sandbox',
                'description' => 'Folder used by personal sandboxes.',
                'descriptionformat' => FORMAT_HTML,
                'parent' => 0,
                'sortorder' => 0,
                'coursecount' => 0,
                'visible' => 0,
                'visibleold' => 0
            ];
            \coursecat::create($data);
        }
        return (int)course_category::get_field(['idnumber'=>'personal_sandbox'],'id');
    }

    /**
     *  Function checks if user has active personal sandbox.
     *
     *
     * @param user|string|int|\stdClass $user
     * @return bool True if user has active sandbox
     * @throws \dml_exception Should not happen, it would mean problem with DB connection itself.
     */
    public static function exist_for_user($user) : bool
    {
        $user=self::resolve_user($user);
        return course_personal_sandbox::exist(['userid'=>$user]);
    }

    /**
     * Return personal sandbox for user. Create if does not exist.
     *
     * @param user|string|int|\stdClass $user
     * @return course_personal_sandbox
     * @throws \coding_exception
     * @throws \dml_exception Should not happen, it would mean problem with DB connection itself.
     * @throws \dml_transaction_exception
     * @throws \moodle_exception
     */
    public static function get_for_user($user) : course_personal_sandbox
    {
        $user=self::resolve_user($user);

        $sandbox=course_personal_sandbox::get(['userid'=>$user]);
        if($sandbox==null)
            $sandbox=self::create_for_user($user);
        return $sandbox;
    }

    /**
     * @param $user
     * @return course_personal_sandbox
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \dml_transaction_exception
     * @throws \moodle_exception
     */
    public static function create_for_user($user) : course_personal_sandbox
    {
        global $DB;

        //User input sanitation
        $user_id=self::resolve_user($user);
        $user_entity=user::get($user_id);

        //Delegated transaction, if one or more operations fails before commit, then we rollback state to this point.
        $transaction=$DB->start_delegated_transaction();

        //Course creation
        $name="Sandbox - {$user_entity->get_fullname()}";
        $data=[
            'shortname'=>$name,
            'fullname'=>$name,
            'idnumber'=>'personal_sandbox:'.$user_entity->get_username(),
            'category'=>self::get_category()
        ];
        $course=\create_course((object)$data);
        $course_id=$course->id;

        // User enrolment
        $enrol=new \enrol_manual_plugin();
        $instance=$DB->get_record('enrol',['courseid'=>$course_id,'enrol'=>'manual']);
        $enrol->enrol_user($instance,$user_id,role::editingteacher()->get_id());

        // Marking course as personal for given user
        $entity=course_personal_sandbox::create($course_id,$user_id);
        $entity->save();

        // Delegated transaction commit
        $DB->commit_delegated_transaction($transaction);

        return $entity;
    }

    public static function reset_for_user($user)
    {
        throw new todo();
    }
    public static function remove_for_user($user)
    {
        throw new todo();
    }
}