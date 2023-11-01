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

use PhacMan\ProjectAnalysis\Data\DataCommandInterface;

interface CommandInterface
{
    const TITLE = 'default title value';

    public function run(): DataCommandInterface;
}
