<?php


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
 * External Web Service Template
 *
 * @package    block_course_menu
 * @copyright  2011 Moodle Pty Ltd (http://moodle.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");
require_once("$CFG->dirroot/config.php");

class block_course_menu_external_block extends external_api
{


    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function update_section_zero_parameters()
    {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'ID from block_course_menu table', false, 0),
                'value' => new external_value(PARAM_INT, 'Whether to show the block in section zero or not',
                    false, 0)
            )
        );
    }

    /**
     * @param $id // Block instance ID
     * @param $value // Whether to show the block in section zero or not
     * @return bool
     * @throws invalid_parameter_exception
     */
    public static function update_section_zero($id, $value)
    {
        global $CFG, $USER, $DB;
        //Parameter validation
        $params = self::validate_parameters(self::update_section_zero_parameters(), array(
                'id' => $id,
                'value' => $value
            )
        );

        //Context validation
        $context = context_block::instance($id);

        $DB->update_record('block_course_menu', [
                'id' => $id,
                'section_zero' => $value,
                'usermodified' => $USER->id,
                'timemodifed' => time()
            ]
        );

        return true;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function update_section_zero_returns()
    {
        return new external_value(PARAM_INT, 'Boolean');
    }

}