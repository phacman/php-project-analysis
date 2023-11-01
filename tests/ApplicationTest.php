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

namespace PhacMan\ProjectAnalysis\Tests;

use Generator;
use PhacMan\ProjectAnalysis\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @dataProvider casesDataProvider
     * @covers       \PhacMan\ProjectAnalysis\Application::run
     * @param  array $argv
     * @param  int   $code
     * @return void
     */
    public function testRun(array $argv, int $code)
    {
        $result = (new Application())->run($argv, false);
        $this->assertEquals($code, $result);
    }

    /**
     * @return Generator
     */
    public static function casesDataProvider(): Generator
    {
        yield [
            'argv' => ['server'],
            'code' => 0,
        ];

        yield [
            'argv' => ['error'],
            'code' => 1,
        ];

        yield [
            'argv' => [],
            'code' => 1,
        ];
    }
}
