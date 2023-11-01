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
use PhacMan\ProjectAnalysis\Command\Phpinfo;
use PhacMan\ProjectAnalysis\Command\Phpini;
use PhacMan\ProjectAnalysis\Command\Server;
use PhacMan\ProjectAnalysis\Util\Commands;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CommandsTest extends TestCase
{
    /**
     * @dataProvider casesDataProvider
     * @covers       \PhacMan\ProjectAnalysis\Util\Commands::get
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
        $commands = (new Commands($path))->get();

        $this->assertIsArray($commands);

        $this->assertArrayHasKey('phpinfo', $commands);
        $this->assertArrayHasKey('phpini', $commands);
        $this->assertArrayHasKey('server', $commands);

        $this->assertCount(2, $commands['phpinfo']);
        $this->assertCount(2, $commands['phpini']);
        $this->assertCount(2, $commands['server']);

        $this->assertEquals(Phpinfo::TITLE, $commands['phpinfo'][1]);
        $this->assertEquals(Phpini::TITLE, $commands['phpini'][1]);
        $this->assertEquals(Server::TITLE, $commands['server'][1]);
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
