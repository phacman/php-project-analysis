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

/**
 * Get information about commands.
 */
class Commands
{
    const EX_MESSAGE = 'Such directory does not exist';
    private const PATH = 'PhacMan\ProjectAnalysis\Command\\';

    public function __construct(
        readonly string $path
    ) {
    }

    /**
     * @return array
     */
    public function get(): array
    {
        if (!file_exists($this->path)) {
            throw new RuntimeException(self::EX_MESSAGE);
        }

        $result = [];
        $items = new RecursiveDirectoryIterator($this->path, FilesystemIterator::SKIP_DOTS);

        /** @var SplFileInfo $file */
        foreach (new RecursiveIteratorIterator($items) as $file) {
            $baseName = $file->getBasename('.php');
            if ($this->isNotCommand($baseName)) {
                continue;
            }
            require_once $file->getPathname();
        }

        return $this->getCommands();
    }

    /**
     * Check command class.
     * @param  string $fileName
     * @return bool
     */
    private function isNotCommand(string $fileName): bool
    {
        return match (true) {
            str_contains($fileName, 'Abstract') => true,
            str_contains($fileName, 'Enum') => true,
            str_contains($fileName, 'Interface') => true,
            str_contains($fileName, 'Trait') => true,
            default => false,
        };
    }

    /**
     * Get actual commands with details.
     * @return array
     */
    private function getCommands(): array
    {
        $result = [];

        $callback = function (string $qualified) {
            return str_starts_with($qualified, self::PATH);
        };

        $items = array_filter(get_declared_classes(), $callback);

        foreach ($items as $qualified) {
            $class = str_replace(self::PATH, '', $qualified);
            $class = strtolower($class);
            $result[$class] = [
                $qualified,
                $qualified::TITLE,
            ];
        }

        ksort($result);

        return $result;
    }
}
