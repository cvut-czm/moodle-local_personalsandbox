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

defined('MOODLE_INTERNAL') || die();

use \local_cool\entity\config_plugin;

function local_personalsandbox_extend_navigation(navigation_node $node) {
    if (config_plugin::get_or_create('local_personalsandbox', 'show_in_sidebar', '1') == '1'
            && has_capability('local/personalsandbox:access', context_system::instance())) {
        $node->add(
                get_string('my_sandbox', 'local_personalsandbox'),
                new moodle_url('/local/personalsandbox/my.php')
        )->showinflatnavigation = true;
    }
}
