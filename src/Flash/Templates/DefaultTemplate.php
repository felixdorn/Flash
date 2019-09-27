<?php
/**
 * This file is part of Flash.
 *
 * Flash is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Flash is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Flash.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Felix\Flash\Templates;


use Felix\Flash\TemplateInterface;

class DefaultTemplate implements TemplateInterface
{
    /**
     * @param string $messages Flashes
     * @param string $type Type of the flashes
     * @return string Html
     */
    public function wrap(string $messages, string $type): string
    {
        return sprintf('<section class="alert alert-%s">%s</section>', $type, $messages);
    }
}