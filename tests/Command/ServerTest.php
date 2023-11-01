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

namespace Command;

use PhacMan\ProjectAnalysis\Command\Server;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    /**
     * @covers       \PhacMan\ProjectAnalysis\Command\Server::run
     * @return void
     */
    public function testRun()
    {
        $result = (new Server())->run();
        $this->assertInstanceOf(DataCommandInterface::class, $result);
        $this->assertEquals(Server::TITLE, $result->getTitle());
        $this->assertIsArray($result->getHeader());
        $this->assertCount(2, $result->getHeader());
        $this->assertIsArray($result->getRows());
    }
}
