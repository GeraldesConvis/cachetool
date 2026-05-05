<?php

/*
 * This file is part of CacheTool.
 *
 * (c) Samuel Gordalina <samuel.gordalina@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CacheTool\Console;

use CacheTool\CacheTool;
use CacheTool\Command\CacheToolAwareCommandInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DummyCommand extends Command implements CacheToolAwareCommandInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('dummy');
    }

    public function setCacheTool(CacheTool $cacheTool): void
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return 42;
    }
}
