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

namespace PhacMan\ProjectAnalysis\Command;

use Exception;
use PhacMan\ConsoleTable\Helper\TableSeparator;
use PhacMan\Process\Exception\ProcessFailedException;
use PhacMan\Process\Process;
use PhacMan\ProjectAnalysis\Data\DataCommand;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;
use PhacMan\ProjectAnalysis\Util\MergeCellsData;

class Phpini implements CommandInterface
{
    const TITLE = 'php.ini file data';

    /**
     * @throws Exception
     * @return DataCommandInterface
     */
    public function run(): DataCommandInterface
    {
        $phpIni = $this->getPhpIniPath();

        if (!$phpIni) {
            throw new Exception('File "php.ini" does not exist');
        }

        $parsed = parse_ini_file($phpIni);
        $columns = [];

        foreach ($parsed as $key => $value) {
            $columns[] = sprintf('%s: %s', $key, $value);
        }

        $rows = array_chunk($columns, 3);
        $values = (new MergeCellsData())->get($phpIni);

        array_unshift($rows, $values, new TableSeparator());
        $rows[] = new TableSeparator();
        $rows[] = $values;

        return (new DataCommand())
            ->setTitle(self::TITLE)
            ->setHeader(['#1', '#2', '#3'])
            ->setRows($rows);
    }

    /**
     * Get path to the php.ini file.
     * @return string
     */
    private function getPhpIniPath(): string
    {
        $result = '';
        $process = new Process(['php', '--ini']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();
        $items = explode(PHP_EOL, $output);

        foreach ($items as $item) {
            if (str_contains($item, 'Loaded Configuration File:')) {
                $arr = explode(':', $item);
                $result = trim(end($arr));
                break;
            }
        }

        return $result;
    }
}
