<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component    = 'local_personal_sandbox';
$plugin->version      = 2018061902;
$plugin->requires     = 2017010100;
$plugin->maturity     = MATURITY_ALPHA;
$plugin->release      = 'v0.1-alpha';
$plugin->dependencies = [
    'local_cool' => ANY_VERSION
];