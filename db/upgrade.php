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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
* This file keeps track of upgrades to the wiki module
*
* Sometimes, changes between versions involve
* alterations to database structures and other
* major things that may break installations.
*
* The upgrade function in this file will attempt
* to perform all the necessary actions to upgrade
* your older installation to the current version.
*
* @package    local
* @subpackage mail
* @copyright  2014 Marc Català <reskit@gmail.com>
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

function xmldb_local_mail_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2014030600) {

        // Define index type_messageid_item (not unique) to be added to local_mail_index.
        $table = new xmldb_table('local_mail_index');
        $index = new xmldb_index('type_messageid_item', XMLDB_INDEX_NOTUNIQUE, array('type', 'messageid', 'item'));

        // Conditionally launch add index type_messageid_item.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Mail savepoint reached.
        upgrade_plugin_savepoint(true, 2014030600, 'local', 'mail');
    }
}