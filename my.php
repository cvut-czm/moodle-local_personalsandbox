<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

use local_cool\form\confirm_form;

require_once('../../config.php');
global $CFG;
require_login();
$PAGE->set_context(context_system::instance());

function handle_no_sandbox()
{
    global $PAGE,$OUTPUT,$USER;
    $editform = new confirm_form(null,['text'=>get_string('form_create_new:text','local_personal_sandbox')]);
    if($editform->is_submitted())
    {
        if($editform->is_cancelled())
            redirect(new moodle_url('/'));
        else
        {
            $entity=\local_personal_sandbox\sandbox::create_for_user((int)$USER->id);
            $url=new moodle_url('/course/view.php',['id'=>$entity->get_course_id()]);
            redirect($url);
        }
    }
    $PAGE->set_url('/local/personal_sandbox/my.php');
    $title=get_string('form_create_new:title','local_personal_sandbox');
    $PAGE->set_title($title);
    $PAGE->set_heading($title);

    echo $OUTPUT->header();

    $editform->display();

    echo $OUTPUT->footer();
}
function handle_sandbox_redirect()
{
    global $USER;
    $entity=\local_personal_sandbox\sandbox::get_for_user((int)$USER->id);
    $url=new moodle_url('/course/view.php',['id'=>$entity->get_course_id()]);
    redirect($url);
}

if(\local_personal_sandbox\sandbox::exist_for_user((int)$USER->id))
    handle_sandbox_redirect();
else {
    //require_capability('local/personal_sandbox:access',context_system::instance());
    handle_no_sandbox();
}

