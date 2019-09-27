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

use Felix\Flash\Templates\DefaultTemplate;

class Flasher implements FlashInterface
{
    public const ARRAY_KEY = '__flash#4f6c07d6f12b98d2ec2e51f77cd6879ece9ab469';
    /**
     * @var Flasher
     */
    private static $instance;
    /**
     * @var TemplateInterface
     */
    private $template;
    /**
     * @var FlashInterface
     */
    private $flash;
    /**
     * @var array
     */
    private $storer;

    public function __construct()
    {
        $this->flash = new Flash();
        $this->storer = [self::ARRAY_KEY => []];
    }

    /**
     * @return Flasher
     * @codeCoverageIgnore
     */
    public static function getInstance(): Flasher
    {
        if (self::$instance instanceof Flasher) {
            return self::$instance;
        }

        self::$instance = new Flasher();

        return self::$instance;
    }

    /**
     * @param array $storer
     * @return $this
     */
    public function setStorer(array &$storer)
    {
        $this->storer = &$storer;

        return $this;
    }

    /**
     * @param TemplateInterface $template
     * @return Flasher
     */
    public function pushTemplate(TemplateInterface $template): Flasher
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return TemplateInterface
     */
    public function getTemplate(): TemplateInterface
    {
        return $this->template ?? new DefaultTemplate();
    }

    /**
     * @param string[]|string $content
     * @param string $type
     * @return Flasher
     */
    public function message($content, string $type): FlashInterface
    {
        $this->flash->message($content, $type);

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return Flasher
     */
    public function error($content): FlashInterface
    {
        $this->flash->error($content);

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return Flasher
     */
    public function warning($content): FlashInterface
    {
        $this->flash->warning($content);

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return Flasher
     */
    public function success($content): FlashInterface
    {
        $this->flash->success($content);

        return $this;
    }

    /**
     * @param string[]|string $content
     * @return Flasher
     */
    public function info($content): FlashInterface
    {
        $this->flash->info($content);

        return $this;
    }

    /**
     * @param string $output
     * @param string $type
     * @return $this
     * @internal
     * @deprecated
     */
    public function register(string $output, string $type)
    {
        $this->handleStorer();

        $this->storer[self::ARRAY_KEY][$type][] = $output;

        return $this;
    }
     /**
      * @codeCoverageIgnore
      * As we can't test that due to $_SESSION limitations
      */
    private function handleStorer()
    {
        if ($this->storer === [self::ARRAY_KEY => []]) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            $this->storer = &$_SESSION;
        }
    }

    /**
     * @param string|null $type
     * @return string
     */
    public function display(?string $type = null): string
    {
        $buffer = '';

        if (array_key_exists(self::ARRAY_KEY, $this->storer) === false) {
            return $buffer;
        }

        if ($type === null) {
            $messages = array_flatten($this->storer[self::ARRAY_KEY]);
            return implode(PHP_EOL, $messages);
        }

        if (array_key_exists($type, $this->storer[self::ARRAY_KEY]) === false) {
            return $buffer;

        }
        $messages = array_flatten($this->storer);

        return implode(PHP_EOL, $messages);
    }

    /**
     * @return Flasher
     */
    public function clear()
    {

        unset($this->storer[self::ARRAY_KEY]);

        return $this;
    }
}