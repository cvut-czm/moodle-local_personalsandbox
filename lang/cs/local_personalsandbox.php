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

$string['pluginname'] = 'Personal sandbox';
$string['my_sandbox'] = 'Můj sandbox';
$string['form_create_new:text'] = 'Zatím nemáte vlastní sandbox. Chcete ho vytvořit?';
$string['form_create_new:title'] = 'Personal sandbox';

/*
 * Settings
 */
$string['settings:show_in_sidebar'] = 'Zobrazit odkaz v sidebar';
$string['settings:show_in_sidebar_desc'] =
        'Pokud toto nechcete, tak můžete odkudkoliv v aplikaci přesměrovat na: <pre><code>/local/personalsandbox/my.php</code></pre>';
$string['settings:remove_after_duration'] = 'Odstranit sandbox po';
$string['settings:remove_after_duration_desc'] =
        'Po tomto čase bude sandbox automaticky odstraněn. <pre><code>Nastavte 0 pro nikdy.</code></pre>';
$string['settings:user_role'] = 'Role uživatele';
$string['settings:user_role_desc'] = 'Která role má být přiřazena uživateli.';
$string['settings:change_name'] = 'Měnitelný název kurzu';
$string['settings:change_name_desc'] = 'Jestli majitel sandboxu může měnit název kurzu';
$string['settings:change_visibility'] = 'Měnitelná viditelnost kurzu';
$string['settings:change_visibility_desc'] = 'Jestli majitel sandboxu může měnit viditelnost kurzu.';
$string['settings:header1'] = 'Personal sandbox';
$string['settings:fakeuser_header'] = 'Testovací účty';
$string['settings:fakeuser/username']='Uživatelské jméno';
$string['settings:fakeuser/username_desc']='Pokaždé bude končit náhodným číslem. Například:<pre><code>fakeuser1999</code></pre>';
$string['settings:fakeuser/password']='Heslo';
$string['settings:fakeuser/password_desc']='';
$string['settings:fakeuser/firstname']='Jméno';
$string['settings:fakeuser/firstname_desc']='';
$string['settings:fakeuser/lastname']='Příjmení';
$string['settings:fakeuser/lastname_desc']='';

/*
 * Tasks
 */
$string['task:clear_old_task_name'] = 'Čištění starých sandboxů';

/*
 * Notifications
 */
$string['notification:course_name_change_prevent'] = 'Nemáte povoleno měnit název sandboxu.';
$string['notification:course_visibility_change_prevent'] = 'Nemáte povoleno měnit viditelnost sandboxu.';
$string['notification:change_prevent_desc'] = 'Změnili jsme to zpět. Všechny ostatní nastavení byly úspěšně uloženy.';

/*
 * Privacy API
 */
$string['privacy:metadata:course_personalsandbox'] = 'Personal sandbox plugin využívá použe ID uživatele k mapování.';
$string['privacy:metadata:course_personalsandbox:userid'] = 'ID uživatele se využívá k jeho mapování k sandboxu.';