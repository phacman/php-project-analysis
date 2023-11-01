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

use PhacMan\ConsoleTable\Helper\TableSeparator;
use PhacMan\ProjectAnalysis\Data\DataCommand;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;

class Server implements CommandInterface
{
    const TITLE = '$_SERVER array data';

    /**
     * @return DataCommandInterface
     */
    public function run(): DataCommandInterface
    {
        unset($_SERVER['COMPOSER_ORIGINAL_INIS'],
            $_SERVER['XDEBUG_HANDLER_SETTINGS'],
            $_SERVER['LS_COLORS'],
            $_SERVER['PATH']
        );

        ksort($_SERVER);
        $rows = [];

        foreach ($_SERVER as $key => $value) {
            $value = match (true) {
                \is_array($value) => implode(';', $value),
                default => $value,
            };
            $rows[] = [$key, $value];
        }

        $rows[] = new TableSeparator();
        $rows[] = [
            'Excluded keys',
            'COMPOSER_ORIGINAL_INIS, XDEBUG_HANDLER_SETTINGS, LS_COLORS, PATH',
        ];

        return (new DataCommand())
            ->setTitle(self::TITLE)
            ->setHeader(['Key', 'Value'])
            ->setRows($rows);
    }
}
