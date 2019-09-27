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


class Flash implements FlashInterface
{

    /**
     * @param string[]|string $content
     * @param string $type
     * @return FlashInterface
     */
    public function message($content, string $type): FlashInterface
    {
        $content = $content = $this->normalizeContent($content);
        $this->flash($content, $type);

        return $this;
    }

    /**
     * @param string|string[] $content
     * @return string
     */
    private function normalizeContent($content): string
    {
        if (is_array($content)) {
            $content = implode(PHP_EOL, $content);
        }

        return $content;
    }

    /**
     * @param string $message
     * @param string $type
     * @return $this
     */
    private function flash(string $message, string $type)
    {
        $output = Flasher::getInstance()->getTemplate()->wrap($message, $type);

        Flasher::getInstance()->register($output, $type);

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function error($content): FlashInterface
    {

        $this->flash($content, 'error');

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function warning($content): FlashInterface
    {
        $content = $content = $this->normalizeContent($content);
        $this->flash($content, 'warning');

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function success($content): FlashInterface
    {
        $content = $content = $this->normalizeContent($content);
        $this->flash($content, 'success');

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return FlashInterface
     */
    public function info($content): FlashInterface
    {
        $content = $content = $this->normalizeContent($content);
        $this->flash($content, 'info');

        return $this;
    }
}