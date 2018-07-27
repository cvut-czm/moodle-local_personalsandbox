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

/**
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    xxxxxx
 * @category   xxxxxx
 * @copyright  2018 CVUT CZM, Jiri Fryc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_personalsandbox;

use local_cool\entity\user;

defined('MOODLE_INTERNAL') || die();

class fake_user {

    /**
     * @return user[]
     */
    public static function get_all(): array {
        return user::get_all(['idnumber' => 'fakeuser%']);
    }

    public static function create_new(): user {
        $randomid = rand(0, 999999);
        $username = sandbox::get_config('fakeuser:username','fakeuser');
        $username.=$randomid;
        $password = sandbox::get_config('fakeuser:password','qwertywhatelse');
        $user= user::get(create_user_record($username, $password)->id);
        $user->set_idnumber($user->get_username());
        $firstname=sandbox::get_config('fakeuser:firstname','Fake');
        $lastname=sandbox::get_config('fakeuser:lastname','User');
        $user->set_firstname($firstname);
        $user->set_lastname($lastname);
        $user->save();
        return $user;
    }
}