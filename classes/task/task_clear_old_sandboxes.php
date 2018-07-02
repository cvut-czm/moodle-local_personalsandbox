<?php
/**
 * Created by PhpStorm.
 * User: frycj
 * Date: 18/06/2018
 * Time: 13:19
 */

namespace local_personal_sandbox\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;
use local_cool\entity\config_plugin;
use local_cool\entity\course;
use local_cool\entity\user;
use local_personal_sandbox\entity\course_personal_sandbox;
use local_personal_sandbox\sandbox;

class task_clear_old_sandboxes extends scheduled_task
{

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name()
    {
        return get_string('task:clear_old_task_name','local_personal_sandbox');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     * @throws \dml_exception
     */
    public function execute()
    {
        //TODO: Need some testing in future.
        $remove_time=config_plugin::get_or_create(sandbox::NAME,'remove_after_duration',0);
        if($remove_time<=0) {
            mtrace('Skipping task. Sandbox removal disabled in config.');
            return;
        }
        $entities=course_personal_sandbox::get_all();
        foreach ($entities as $entity)
        {
            $course=$entity->get_course();
            /** @var course $course */
            if($course->get_time_created()+$remove_time<=time())
            {
                $user=$entity->get_owner();
                /** @var user $user */
                mtrace('Removing personal sandbox of user '.$user->get_username());
                delete_course($course->get_id());
                $entity->remove_from_db();
            }


        }

    }
}