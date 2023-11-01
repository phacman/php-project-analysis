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

use Exception;
use PhacMan\ProjectAnalysis\Command\Phpini;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;
use PHPUnit\Framework\TestCase;

class PhpiniTest extends TestCase
{
    /**
     * @covers       \PhacMan\ProjectAnalysis\Command\Phpini::run
     * @throws Exception
     * @return void
     */
    public function testRun()
    {
        $result = (new Phpini())->run();
        $this->assertInstanceOf(DataCommandInterface::class, $result);
        $this->assertEquals(Phpini::TITLE, $result->getTitle());
        $this->assertIsArray($result->getHeader());
        $this->assertCount(3, $result->getHeader());
        $this->assertIsArray($result->getRows());
    }
}
