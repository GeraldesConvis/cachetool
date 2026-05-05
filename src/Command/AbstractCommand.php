<?php

/*
 * This file is part of CacheTool.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CacheTool\Command;

use CacheTool\CacheTool;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command implements CacheToolAwareCommandInterface
{
    /**
     * @var CacheTool|null
     */
    protected $cacheTool;

    /**
     * @return CacheTool
     */
    protected function getCacheTool()
    {
        if (!$this->cacheTool instanceof CacheTool) {
            throw new \LogicException('CacheTool was not initialized for this command.');
        }

        return $this->cacheTool;
    }

    /**
     * @param  string $extension
     */
    protected function ensureExtensionLoaded($extension)
    {
        if (!$this->getCacheTool()->extension_loaded($extension)) {
            throw new \Exception("Extension `{$extension}` is not loaded");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setCacheTool(CacheTool $cacheTool): void
    {
        $this->cacheTool = $cacheTool;
    }
}
