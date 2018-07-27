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
 * This class provide full control over sandboxes.
 *
 * @package local_personalsandbox
 * @category core
 * @copyright 2018 CVUT CZM, Jiri Fryc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_personalsandbox;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

use local_cool\entity\course_category;
use local_cool\entity\role;
use local_cool\entity\user;
use local_cool\todo;
use local_personalsandbox\entity\course_personalsandbox;

class sandbox {
    public const NAME = 'local_personalsandbox';

    /**
     * Method for resolving user from username,user_id, entity class or stdClass.
     *
     * Fallback with hard cast to int if object is neither of this types.
     *
     * @param  \stdClass|user|int|string $user Inputed user
     * @return int ID of user
     * @throws \dml_exception Should not happen, it would mean problem with DB connection itself.
     */
    private static function resolve_user($user): int {
        if (is_string($user)) {
            $user = user::get_field(['username' => $user], 'id');
        } else if ($user instanceof user) {
            $user = $user->get_id();
        } else if ($user instanceof \stdClass) {
            /** @var \stdClass $user */
            $user = $user->id;
        }
        return (int) $user;
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
    public static function get_category(): int {
        if (!course_category::exist(['idnumber' => 'personalsandbox'])) {
            $data = [
                    'name' => 'Personal sandboxes',
                    'idnumber' => 'personalsandbox',
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
        return (int) course_category::get_field(['idnumber' => 'personalsandbox'], 'id');
    }

    /**
     *  Function checks if user has active personal sandbox.
     *
     *
     * @param user|string|int|\stdClass $user
     * @return bool True if user has active sandbox
     * @throws \dml_exception Should not happen, it would mean problem with DB connection itself.
     */
    public static function exist_for_user($user): bool {
        $user = self::resolve_user($user);
        return course_personalsandbox::exist(['userid' => $user]);
    }

    /**
     * Return personal sandbox for user. Create if does not exist.
     *
     * @param user|string|int|\stdClass $user
     * @return course_personalsandbox
     * @throws \coding_exception
     * @throws \dml_exception Should not happen, it would mean problem with DB connection itself.
     * @throws \dml_transaction_exception
     * @throws \moodle_exception
     */
    public static function get_for_user($user): course_personalsandbox {
        $user = self::resolve_user($user);

        $sandbox = course_personalsandbox::get(['userid' => $user]);
        if ($sandbox == null) {
            $sandbox = self::create_for_user($user);
        }
        return $sandbox;
    }

    /**
     * @param $user
     * @return course_personalsandbox
     * @throws \coding_exception
     * @throws \dml_exception
     * @throws \dml_transaction_exception
     * @throws \moodle_exception
     */
    public static function create_for_user($user): course_personalsandbox {
        global $DB;

        // User input sanitation.
        $userid = self::resolve_user($user);
        $userentity = user::get($userid);

        // Delegated transaction, if one or more operations fails before commit, then we rollback state to this point.
        $transaction = $DB->start_delegated_transaction();

        // Course creation.
        $name = "Sandbox - {$userentity->get_fullname()}";
        $data = [
                'shortname' => $name,
                'fullname' => $name,
                'idnumber' => 'personalsandbox:' . $userentity->get_username(),
                'category' => self::get_category()
        ];
        $course = \create_course((object) $data);
        $courseid = $course->id;

        // User enrolment.
        $enrol = new \enrol_manual_plugin();
        $instance = $DB->get_record('enrol', ['courseid' => $courseid, 'enrol' => 'manual']);
        $enrol->enrol_user($instance, $userid, role::editingteacher()->get_id());

        // Marking course as personal for given user.
        $entity = course_personalsandbox::create($courseid, $userid);
        $entity->save();

        // Delegated transaction commit.
        $DB->commit_delegated_transaction($transaction);

        return $entity;
    }

    public static function reset_for_user($user) {
        throw new todo();
    }

    public static function remove_for_user($user) {
        throw new todo();
    }

    public static function get_config(string $name, string $default = ''): string {
        $value = get_config('local_personalsandbox', $name);
        if ($value === false) {
            if ($default == '') {
                return null;
            } else {
                $value = $default;
                set_config($name, $value, 'local_personalsandbox');
            }
        }
        return $value;
    }
}