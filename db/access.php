<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = [];
$capabilities['local/personal_sandbox:create'] = [
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM
];
$capabilities['local/personal_sandbox:access'] = [
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM
];
$capabilities['local/personal_sandbox:update'] = [
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE
];