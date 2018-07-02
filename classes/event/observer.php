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
 * Event observer
 *
 * Used for course_delete and course_changed events
 *
 * @package local_personal_sandbox\event
 * @category event
 * @copyright 2018 CVUT CZM, Jiri Fryc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_personal_sandbox\event;

defined('MOODLE_INTERNAL') || die();

use local_cool\entity\config_plugin;
use local_personal_sandbox\entity\course_personal_sandbox;
use local_personal_sandbox\sandbox;

class observer {
    public static function deleted_course(\core\event\course_deleted $event) {
        $entity = course_personal_sandbox::get(['courseid' => $event->courseid]);
        if ($entity == null) {
            return;
        }
        $entity->remove_from_db();
    }

    public static function changed_course(\core\event\course_updated $event) {
        $entity = course_personal_sandbox::get(['courseid' => $event->courseid]);
        if ($entity == null) {
            return;
        }

        $course = $entity->get_course();
        $realname = $entity->get_name();
        $idnumber = $entity->get_idnumber();
        $category = sandbox::get_category();

        // Id number must always match!!
        if ($idnumber != $course->get_idnumber()) {
            $course->set_idnumber($idnumber)->save();
        }

        // Category must always match!!
        if ($category != $course->get_category_id()) {
            $course->set_category_id($category)->save();
        }

        // Check if user can change sandbox name, if not revert changes.
        if ((bool) config_plugin::get_or_create(sandbox::NAME, 'change_name', 'false') == false) {
            if ($realname != $course->get_shortname() || $realname != $course->get_fullname()) {
                $course->set_shortname($realname)->set_fullname($realname)->save();
                \core\notification::error(get_string('notification:course_name_change_prevent', sandbox::NAME));
            }
        }

        // Check if user can change sandbox visibility if not revert changes.
        if ((bool) config_plugin::get_or_create(sandbox::NAME, 'change_visibility', 'false') == false) {
            if ($course->get_visibility() == 1) {
                $course->set_visibility(0)->save();
                \core\notification::error(get_string('notification:course_visibility_change_prevent', sandbox::NAME));
            }
        }

    }
}