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

namespace PhacMan\ProjectAnalysis\Tests\Util;

use Generator;
use PhacMan\ConsoleTable\Helper\TableCell;
use PhacMan\ConsoleTable\Helper\TableCellStyle;
use PhacMan\ProjectAnalysis\Util\MergeCellsData;
use PHPUnit\Framework\TestCase;

class MergeCellsDataTest extends TestCase
{
    const SECTION = 'Some Section';

    /**
     * @dataProvider casesDataProvider
     * @covers       \PhacMan\ProjectAnalysis\Util\MergeCellsData::get
     * @param  string $section
     * @param  int    $colspan
     * @param  int    $repeat
     * @return void
     */
    public function testGet(string $section, int $colspan, int $repeat)
    {
        $result = (new MergeCellsData())->get($section, $colspan, $repeat);

        $tableCell = current($result);
        $style = $tableCell->getStyle();
        $opts = $style->getOptions();

        $this->assertIsArray($result);
        $this->assertInstanceOf(TableCell::class, $tableCell);
        $this->assertEquals($colspan, $tableCell->getColspan());
        $this->assertInstanceOf(TableCellStyle::class, $style);
        $this->assertIsArray($opts);
        $this->assertArrayHasKey('align', $opts);
        $this->assertArrayHasKey('fg', $opts);
        $this->assertEquals('center', $opts['align']);
        $this->assertEquals('cyan', $opts['fg']);

        $dashes = substr_count($tableCell->__toString(), '-');
        $this->assertEquals($repeat * 2, $dashes);
        $this->assertMatchesRegularExpression(
            sprintf('/%s/', self::SECTION),
            $tableCell->__toString()
        );
    }

    /**
     * @return Generator
     */
    public static function casesDataProvider(): Generator
    {
        yield [
            'section' => self::SECTION,
            'colspan' => 3,
            'repeat' => 10,
        ];
    }
}
