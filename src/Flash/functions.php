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

use Felix\Flash\Flash;
use Felix\Flash\Flasher;
use Felix\Flash\FlashInterface;

if (!function_exists('flash')) {
    function flash($content, ?string $type = null): FlashInterface
    {
        $flash = new Flash();

        if ($content === null && $type === null) {
            return $flash;
        }

        return $flash->message($content, $type);
    }
}

if (!function_exists('array_flatten')) {
    function array_flatten($array = null)
    {
        $result = array();

        if (!is_array($array)) {
            $array = func_get_args();
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }

        return $result;
    }
}

if (!function_exists('displayFlashes')) {
    function displayFlashes()
    {
        return call_user_func_array([Flasher::class, 'display'], func_get_args());
    }
}

if (!function_exists('clearFlashes')) {
    function clearFlashes()
    {
    }
}