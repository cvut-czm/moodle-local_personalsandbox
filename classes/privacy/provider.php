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
 * Privacy provider
 *
 * @package local_personal_sandbox
 * @category privacy
 * @copyright 2018 CVUT CZM, Jiri Fryc
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_personal_sandbox\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\writer;
use local_personal_sandbox\entity\course_personal_sandbox;

class provider implements \core_privacy\local\metadata\provider
{

    /**
     * Returns meta data about this system.
     *
     * @param   collection $collection The initialised collection to add items to.
     * @return  collection     A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection): collection
    {
        $collection->add_database_table('course_personal_sandbox',
            [
                'userid' => 'privacy:metadata:course_personal_sandbox:userid'
            ],
            'privacy:metadata:course_personal_sandbox'
        );

        return $collection;
    }

    public static function get_contexts_for_userid(int $userid) : \core_privacy\local\request\contextlist
    {
        $contextlist=new \core_privacy\local\request\contextlist();

        $sql = "SELECT c.id FROM {context} c
                INNER JOIN {course_personal_sandbox} cps ON cps.courseid = c.instanceid AND c.contextlevel = :contextlevel 
                WHERE (cps.userid = :userid)";

        $contextlist->add_from_sql($sql, ['contextlevel'=>CONTEXT_COURSE,'userid'=>$userid]);
        return $contextlist;
    }

    public static function delete_data_for_all_users_in_context(\context $context)
    {
        if($context->contextlevel!=CONTEXT_COURSE)
            return;

        $sandbox=course_personal_sandbox::get(['courseid'=>$context->instanceid]);
        if($sandbox==null)
            return;
        delete_course($sandbox->get_course_id());
        $sandbox->remove_from_db();
    }

    public static function delete_data_for_user(approved_contextlist $contextlist)
    {
        if(empty($contextlist->count()))
            return;

        $userid=$contextlist->get_user()->id;
        foreach($contextlist->get_contexts() as $context)
        {
            if($context!=CONTEXT_COURSE)
                continue;
            $sandbox=course_personal_sandbox::get(['courseid'=>$context->instanceid,'userid'=>$userid]);
            if($sandbox==null)
                continue;
            delete_course($sandbox->get_course_id());
            $sandbox->remove_from_db();

        }
    }

    public static function export_user_data(approved_contextlist $contextlist)
    {
        if (empty($contextlist->count()))
            return;

        $userid = $contextlist->get_user()->id;
        foreach ($contextlist->get_contexts() as $context) {
            if ($context != CONTEXT_COURSE)
                continue;
            $sandbox=course_personal_sandbox::get(['courseid'=>$context->instanceid,'userid'=>$userid]);
            if($sandbox==null)
                continue;

            writer::with_context($context)->export_metadata([],
                'sandboxcourse',
                $sandbox->get_course_id(),
                get_string('',''));
        }
    }
}