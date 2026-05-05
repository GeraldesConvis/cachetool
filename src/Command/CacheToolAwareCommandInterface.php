<?php

/*
 * This file is part of CacheTool.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CacheTool\Command;

use CacheTool\CacheTool;

interface CacheToolAwareCommandInterface
{
    public function setCacheTool(CacheTool $cacheTool): void;
}
