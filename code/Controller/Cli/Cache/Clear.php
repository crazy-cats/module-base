<?php

/*
 * Copyright © 2020 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Base\Controller\Cli\Cache;

use CrazyCat\Framework\App\Cache\Manager as CacheManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @category CrazyCat
 * @package  CrazyCat\Developer
 * @author   Liwei Zeng <zengliwei@163.com>
 * @link     https://crazy-cat.cn
 */
class Clear extends \CrazyCat\Framework\App\Component\Module\Controller\Cli\AbstractAction
{
    public const INPUT_KEY_CACHE_NAME = 'cache_name';

    /**
     * @param \Symfony\Component\Console\Command\Command $command
     * @throws \ReflectionException
     */
    protected function configure(Command $command)
    {
        $cacheManager = $this->objectManager->get(CacheManager::class);
        $command->setDefinition(
            [
                new InputArgument(self::INPUT_KEY_CACHE_NAME, InputArgument::OPTIONAL, 'Type of cache to clear')
            ]
        );
        $command->setDescription('Clear cache of specified type');

        $cacheNames = $cacheManager->getAllCacheNames();
        sort($cacheNames);
        $command->setHelp('Types: ' . implode(', ', $cacheNames));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $cacheManager \CrazyCat\Framework\App\Cache\Manager */
        $cacheManager = $this->objectManager->get(CacheManager::class);
        if (($cacheName = $input->getArgument(self::INPUT_KEY_CACHE_NAME))) {
            if (($cache = $cacheManager->get($cacheName)) === null) {
                $output->writeln(sprintf('<error>Specified cache `%s` does not exist.</error>', $cacheName));
            } else {
                $output->writeln(sprintf('<info>Cache `%s` cleared.</info>', $cacheName));
            }
        } else {
            $cacheNames = $cacheManager->getAllCacheNames();
            sort($cacheNames);
            foreach ($cacheNames as $cacheName) {
                try {
                    $cache = $cacheManager->get($cacheName) ?: $cacheManager->create($cacheName);
                    $cache->clear(true);
                    $output->writeln(sprintf('<info>Cache `%s` cleared.</info>', $cacheName));
                } catch (\Exception $e) {
                    $output->writeln(sprintf('<error>Failed to clear `%s`.</error>', $cacheName));
                }
            }
        }
        $output->writeln('');
    }
}
