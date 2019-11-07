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
    private $storer = null;

    public function __construct()
    {
        $this->flash = new Flash();
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
     * @param array|\ArrayAccess $storer
     * @return $this
     */
    public function setStorer(&$storer)
    {
        $this->storer = &$storer;

        return $this;
    }

    /**
     * @param TemplateInterface $template
     * @return Flasher
     */
    public function setTemplate(TemplateInterface $template): Flasher
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param TemplateInterface $template
     * @return Flasher
     * @deprecated
     */
    public function pushTemplate(TemplateInterface $template): Flasher
    {
        return $this->setTemplate($template);
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

        $this->storer[$type][] = $output;

        return $this;
    }
     /**
      * @codeCoverageIgnore
      * As we can't test that due to $_SESSION limitations
      */
    private function handleStorer()
    {
        if ($this->storer === null) {
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_start();   
            }
            $this->storer = &$_SESSION;
        }
    }

    /**
     * @param string|null $type
     * @return string
     */
    public function render(?string $type = null): string
    {
        $buffer = '';

        if ($type === null) {
            $messages = Utils::array_flatten($this->storer);
            return implode(PHP_EOL, $messages);
        }

        if (isset($this->storer[$type]) === false) {
            return $buffer;

        }
        $messages =  Utils::array_flatten($this->storer);

        return implode(PHP_EOL, $messages);
    }


    /**
     * @param string|null $type
     * @return string
     * @deprecated
     */
    public function display(?string $type = null): string
    {
        return $this->render($type);
    }

    /**
     * @return Flasher
     */
    public function clear()
    {

        foreach($this->storer as $k => $v) {
            unset($this->storer[$k]);
        }

        return $this;
    }
}
