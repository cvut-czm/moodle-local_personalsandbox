<?php
/**
 * Created by PhpStorm.
 * User: frycj
 * Date: 18/06/2018
 * Time: 14:05
 */

$observers = [
        [
                'eventname' => '\core\event\course_updated',
                'callback' => 'local_personal_sandbox\event\observer::changed_course',
                'priority' => 0,
            //It is probable that we will change data to valid sandbox format that should not be changed, or completely do nothing.
                'internal' => false
        ],
        [
                'eventname' => '\core\event\course_deleted',
                'callback' => 'local_personal_sandbox\event\observer::deleted_course',
                'priority' => 0,
            //It is probable that we will change data to valid sandbox format that should not be changed, or completely do nothing.
                'internal' => false
        ]
];