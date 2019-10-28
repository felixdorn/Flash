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

namespace Felix\Flash;


use Felix\Tests\Flash\FlasherTest;

interface FlashInterface
{
    /**
     * @param string[]|string $content
     * @param string $type
     * @return FlashInterface
     */
    public function message($content, string $type): FlashInterface;

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function error($content): FlashInterface;

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function warning($content): FlashInterface;

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function success($content): FlashInterface;

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function info($content): FlashInterface;
}