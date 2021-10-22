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
 * Collapsed Topics Information
 *
 * A topic based format that solves the issue of the 'Scroll of Death' when a course has many topics. All topics
 * except zero have a toggle that displays that topic. One or more topics can be displayed at any given time.
 * Toggles are persistent on a per browser session per course basis but can be made to persist longer by a small
 * code change. Full installation instructions, code adaptions and credits are included in the 'Readme.txt' file.
 *
 * A trait to contain all of the deprecated methods, but implemented using the new components.  Thus easing migration.
 * Note: 'courseformat' property is set in the using class constructor.
 *
 * @package    format_topcoll
 * @version    See the value of '$plugin->version' in version.php.
 * @copyright  &copy; 2021-onwards G J Barnard in respect to modifications of core code.
 * @author     G J Barnard - {@link http://moodle.org/user/profile.php?id=442195}
 * @link       http://docs.moodle.org/en/Collapsed_Topics_course_format
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 *
 */

namespace format_topcoll\output;

defined('MOODLE_INTERNAL') || die();

use html_writer;

trait format_renderer_migration_toolbox {

    /**
     * Displays availability information for the section (hidden, not available unless, etc.)
     *
     * @deprecated since 4.0 MDL-72656 - use core_course output components instead.
     *
     * This element is now a section_format output component and it is displayed using
     * mustache templates instead of a renderer method.
     *
     * @param section_info $section
     * @return string
     */
    public function section_availability($section) {
        // TODO: Update to a template!
        $widgetclass = $this->courseformat->get_output_classname('content\\section\\availability');
        $widget = new $widgetclass($this->courseformat, $section);
        return html_writer::div($this->render($widget), 'section_availability');
    }

    /**
     * Generate html for a section summary text
     *
     * @deprecated since 4.0 MDL-72656 - use core_course output components instead.
     *
     * @param stdClass $section The course_section entry from DB
     * @return string HTML to output.
     */
    protected function format_summary_text($section) {
        if (!($section instanceof section_info)) {
            $modinfo = $this->courseformat->get_modinfo();
            $section = $modinfo->get_section_info($section->section);
        }
        $summaryclass = $this->courseformat->get_output_classname('content\\section\\summary');
        $summary = new $summaryclass($this->courseformat, $section);
        return $summary->format_summary_text();
    }
    
    protected function course_section_cmlist($section) {
        $cmlistclass = $this->courseformat->get_output_classname('content\\section\\cmlist');
        return $this->render(new $cmlistclass($this->courseformat, $section));
    }
}