<?php

declare(strict_types=1);

/*
 * This file is part of Project Analysis package.
 *
 * (c) Pavel Vasin <phacman@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhacMan\ProjectAnalysis\Util;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;

class LoadClasses
{
    /**
     * @param  string $path
     * @return array
     */
    public function load(string $path): array
    {
        $result = [];

        if (!file_exists($path)) {
            throw new RuntimeException(Commands::EX_MESSAGE);
        }

        $items = new RecursiveDirectoryIterator(
            $path,
            FilesystemIterator::SKIP_DOTS
        );

        /** @var SplFileInfo $file */
        foreach (new RecursiveIteratorIterator($items) as $file) {
            $result[] = $file->getPathname();
        }

        return $result;
    }
}
