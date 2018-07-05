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

use local_cool\form\confirm_form;

require_once('../../config.php');
global $CFG;
require_login();
$PAGE->set_context(context_system::instance());

function handle_no_sandbox() {
    global $PAGE, $OUTPUT, $USER;
    $editform = new confirm_form(null, ['text' => get_string('form_create_new:text', 'local_personalsandbox')]);
    if ($editform->is_submitted()) {
        if ($editform->is_cancelled()) {
            redirect(new moodle_url('/'));
        } else {
            $entity = \local_personalsandbox\sandbox::create_for_user((int) $USER->id);
            $url = new moodle_url('/course/view.php', ['id' => $entity->get_course_id()]);
            redirect($url);
        }
    }
    $PAGE->set_url('/local/personalsandbox/my.php');
    $title = get_string('form_create_new:title', 'local_personalsandbox');
    $PAGE->set_title($title);
    $PAGE->set_heading($title);

    echo $OUTPUT->header();

    $editform->display();

    echo $OUTPUT->footer();
}

function handle_sandbox_redirect() {
    global $USER;
    $entity = \local_personalsandbox\sandbox::get_for_user((int) $USER->id);
    $url = new moodle_url('/course/view.php', ['id' => $entity->get_course_id()]);
    redirect($url);
}

if (\local_personalsandbox\sandbox::exist_for_user((int) $USER->id)) {
    handle_sandbox_redirect();
} else {
    require_capability('local/personalsandbox:access', context_system::instance());
    handle_no_sandbox();
}

