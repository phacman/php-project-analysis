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

class DataCommand implements DataCommandInterface
{
    private string $title = '';
    private array $header = [];
    private array $rows = [];

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): DataCommandInterface
    {
        $this->title = $title;

        return $this;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader(array $header): DataCommandInterface
    {
        $this->header = $header;

        return $this;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setRows(array $rows): DataCommandInterface
    {
        $this->rows = $rows;

        return $this;
    }
}
