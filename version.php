<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component    = 'local_personal_sandbox';
$plugin->version      = 2018070200;
$plugin->requires     = 2018010100;
$plugin->maturity     = MATURITY_BETA;
$plugin->release      = 'v0.2-beta';
$plugin->dependencies = [
    'local_cool' => ANY_VERSION
];