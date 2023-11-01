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

namespace PhacMan\ProjectAnalysis;

use PhacMan\ConsoleTable\Table;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;

/**
 * Console application.
 */
class Application
{
    /**
     * @param  array $argv
     * @param  bool  $show
     * @return int
     */
    public function run(array $argv, bool $show = true): int
    {
        $dirCommands = __DIR__.'/Command';
        $commands = (new Util\Commands($dirCommands))->get();

        if (!$argv) {
            if ($show) {
                echo $this->getInfoMessage($commands);
            }

            return 1;
        }

        $command = strtolower(trim($argv[0]));

        if (!\in_array($command, array_keys($commands), true)) {
            if ($show) {
                echo "There is\e[0;31m no such command\e[0m \"{$command}\"\n";
            }

            return 1;
        }

        $qualified = current($commands[$command]);
        $script = new $qualified();
        /** @var DataCommandInterface $data */
        $data = $script->run();

        $table = new Table();

        $table
            ->setHeaderTitle($data->getTitle())
            ->setFooterTitle($data->getTitle())
            ->setHeaders($data->getHeader())
            ->setRows($data->getRows())
        ;

        if ($show) {
            $table->render();
        }

        return 0;
    }

    /**
     * Prepare info message.
     * @param  array  $items
     * @return string
     */
    private function getInfoMessage(array $items): string
    {
        $result = ["You\e[1;35m should enter\e[0m one of the commands:"];

        foreach ($items as $command => $value) {
            $description = end($value);
            $result[] = sprintf(" -\e[0;36m %s\e[0m: \e[0;37m %s\e[0m", $command, $description);
        }

        return implode("\n", $result)."\n";
    }
}
