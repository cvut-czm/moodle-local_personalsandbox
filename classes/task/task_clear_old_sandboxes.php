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
 * Task for clearing old sandboxes
 *
 * @package local_personal_sandbox\task
 * @category task
 * @copyright 2018 CVUT CZM, Jiri Fryc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_personal_sandbox\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;
use local_cool\entity\config_plugin;
use local_cool\entity\course;
use local_cool\entity\user;
use local_personal_sandbox\entity\course_personal_sandbox;
use local_personal_sandbox\sandbox;

class task_clear_old_sandboxes extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('task:clear_old_task_name', 'local_personal_sandbox');
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     *
     * @throws \dml_exception
     */
    public function execute() {
        // TODO: Need some testing in future.
        $removetime = config_plugin::get_or_create(sandbox::NAME, 'remove_after_duration', 0);
        if ($removetime <= 0) {
            mtrace('Skipping task. Sandbox removal disabled in config.');
            return;
        }
        $entities = course_personal_sandbox::get_all();
        foreach ($entities as $entity) {
            /** @var course $course */
            $course = $entity->get_course();
            if ($course->get_time_created() + $removetime <= time()) {
                /** @var user $user */
                $user = $entity->get_owner();
                mtrace('Removing personal sandbox of user ' . $user->get_username());
                delete_course($course->get_id());
                $entity->remove_from_db();
            }

        }

    }
}