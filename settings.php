<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */
defined('MOODLE_INTERNAL') || die;
if ( $hassiteconfig ){

    $settings = new admin_settingpage( 'local_personal_sandbox', 'Personal sandbox' );
    $ADMIN->add( 'localplugins', $settings );

    $settings->add(new admin_setting_heading('local_personal_sandbox/seminar_header1', get_string('settings:header1', 'local_personal_sandbox'),''));
    \local_cool\entity\config_plugin::get_or_create('local_personal_sandbox','show_in_sidebar','1');

    $settings->add(new admin_setting_configcheckbox('local_personal_sandbox/show_in_sidebar', get_string('settings:show_in_sidebar', 'local_personal_sandbox'),
        get_string('settings:show_in_sidebar_desc', 'local_personal_sandbox'), '1'));
    \local_cool\entity\config_plugin::get_or_create('local_personal_sandbox','remove_after_duration','86400');
    $settings->add(new admin_setting_configduration(
        'local_personal_sandbox/remove_after_duration',
        get_string('settings:remove_after_duration', 'local_personal_sandbox'),
        get_string('settings:remove_after_duration_desc', 'local_personal_sandbox'),0
    ));

    $role_entities=\local_cool\entity\role::get_all();
    $roles=[];
    $default=null;
    foreach($role_entities as $entity) {
        if($default==null || $entity->get_shortname()==='editingteacher')
            $default=$entity->get_id();
        $roles[$entity->get_id()] = $entity->get_shortname();
    }
    \local_cool\entity\config_plugin::get_or_create('local_personal_sandbox','user_role',$default);
    $settings->add(new admin_setting_configselect(
        'local_personal_sandbox/user_role',
        get_string('settings:user_role','local_personal_sandbox'),
        get_string('settings:user_role_desc','local_personal_sandbox'),
        $default,
        $roles
    ));

    \local_cool\entity\config_plugin::get_or_create('local_personal_sandbox','change_name','0');
    $settings->add(new admin_setting_configcheckbox('local_personal_sandbox/change_name', get_string('settings:change_name', 'local_personal_sandbox'),
        get_string('settings:change_name_desc', 'local_personal_sandbox'), '0'));
    \local_cool\entity\config_plugin::get_or_create('local_personal_sandbox','change_visibility','0');
    $settings->add(new admin_setting_configcheckbox('local_personal_sandbox/change_visibility', get_string('settings:change_visibility', 'local_personal_sandbox'),
        get_string('settings:change_visibility_desc', 'local_personal_sandbox'), '0'));

}