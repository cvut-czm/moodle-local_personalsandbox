<?php
/**
 * Created by PhpStorm.
 * User: frycj
 * Date: 18/06/2018
 * Time: 13:51
 */

$tasks = [
        [
                'classname' => 'local_personal_sandbox\task\task_clear_old_sandboxes',
                'blocking' => 1,  // We are actively removing courses in this task. This could interfere with other tasks.
                'minute' => 'R', // Random
                'hour' => '2',
                'day' => '*'
        ]
];