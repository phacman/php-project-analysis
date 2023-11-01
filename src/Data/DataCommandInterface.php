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

namespace PhacMan\ProjectAnalysis\Data;

interface DataCommandInterface
{
    public function getTitle(): string;

    public function setTitle(string $title): DataCommandInterface;

    public function getHeader(): array;

    public function setHeader(array $header): DataCommandInterface;

    public function getRows(): array;

    public function setRows(array $rows): DataCommandInterface;
}
