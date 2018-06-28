<?php
/**
 * Created by CTU CZM.
 * Author: Jiri Fryc
 * License: GNU GPLv3
 */

class edit_page extends \local_cool\page\abstract_page
{

    protected function global_permission(\local_cool\page\permissionsex $perm)
    {
        $perm->require_logged()->require_capability('local/personal_sandbox:update');
    }
    protected function context(): \context
    {
        return context_course::instance($this->require_param('id'));
    }

    function run()
    {
        // TODO: Implement run() method.
    }

}
edit_page::execute();