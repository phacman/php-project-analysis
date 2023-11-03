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
use PhacMan\ProjectAnalysis\Util\Commands;
use PhacMan\ProjectAnalysis\Util\LoadClasses;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class LoadClassesTest extends TestCase
{
    /**
     * @dataProvider casesDataProvider
     * @covers       \PhacMan\ProjectAnalysis\Util\LoadClasses::load
     * @param  string $path
     * @param  bool   $exception
     * @return void
     */
    public function testGet(string $path, bool $exception)
    {
        if ($exception) {
            $this->expectException(RuntimeException::class);
            $this->expectExceptionMessage(Commands::EX_MESSAGE);
        }

        $paths = (new LoadClasses())->load($path);
        $this->assertIsArray($paths);
    }

    /**
     * @return Generator
     */
    public static function casesDataProvider(): Generator
    {
        yield [
            'path' => '/some/wrong/path',
            'exception' => true,
        ];

        yield [
            'path' => \dirname(__DIR__, 2).'/src/Command',
            'exception' => false,
        ];
    }
}
