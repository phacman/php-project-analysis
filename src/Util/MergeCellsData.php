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

use PhacMan\ConsoleTable\Helper\TableCell;
use PhacMan\ConsoleTable\Helper\TableCellStyle;

class MergeCellsData
{
    public function get(string $section, int $colspan = 3, int $repeat = 10): array
    {
        $sep = str_repeat('-', $repeat);
        $title = sprintf("\e[0;36m %s %s %s\e[0m", $sep, $section, $sep);
        $style = new TableCellStyle(['align' => 'center', 'fg' => 'cyan']);

        return [new TableCell($title, ['colspan' => $colspan, 'style' => $style])];
    }
}
