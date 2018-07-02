<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

$string['pluginname']='Personal sandbox';
$string['my_sandbox']='My sandbox';
$string['form_create_new:text']='You don´t have personal sandbox course yet. Do you want to create new sandbox?';
$string['form_create_new:title']='Personal sandbox';

/*
 * Settings
 */
$string['settings:show_in_sidebar']='Show link in sidebar';
$string['settings:show_in_sidebar_desc']='If you don´t want this, you can just point from anywhere to: <pre><code>/local/personal_sandbox/my.php</code></pre>';
$string['settings:remove_after_duration']='Lifetime of sandboxes';
$string['settings:remove_after_duration_desc']='After this duration the sandbox will be automatically removed.<pre><code>Set to 0 for never delete sandboxes.</code></pre>';
$string['settings:user_role']='User role';
$string['settings:user_role_desc']='Role that is assigned in personal sandbox to owner.';
$string['settings:change_name']='Changeable sandbox name';
$string['settings:change_name_desc']='If sandbox owner can change sandbox course name.';
$string['settings:change_visibility']='Changeable sandbox visibility';
$string['settings:change_visibility_desc']='If sandbox owner can change sandbox course visibility.';
$string['settings:header1']='Personal sandbox';
$string['settings:header2']='Seminar sandbox';


/*
 * Tasks
 */
$string['task:clear_old_task_name']='Clearing old sandboxes';


/*
 * Notifications
 */
$string['notification:course_name_change_prevent']='You are not allowed to change name of sandbox course.';
$string['notification:course_visibility_change_prevent']='You are not allowed to change visibility of sandbox course.';
$string['notification:change_prevent_desc']='We change it back. All other settings you might changed were saved successfully.';

/*
 * Privacy API
 */
$string['privacy:metadata:course_personal_sandbox']='The personal sandbox plugin only need user id for his mapping to sandbox.';
$string['privacy:metadata:course_personal_sandbox:userid']='User ID is used for mapping user to his sandbox.';