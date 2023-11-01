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

use PhacMan\ProjectAnalysis\Data\DataCommand;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;
use PhacMan\ProjectAnalysis\Util\MergeCellsData;

class Phpinfo implements CommandInterface
{
    const TITLE = 'phpinfo() function data';

    /**
     * @return DataCommandInterface
     */
    public function run(): DataCommandInterface
    {
        $general = $this->getArrayData('GENERAL', INFO_GENERAL);
        $configuration = $this->getArrayData('CONFIGURATION', INFO_CONFIGURATION);
        $modules = $this->getArrayData('MODULES', INFO_MODULES);
        $environment = $this->getArrayData('ENVIRONMENT', INFO_ENVIRONMENT);

        $rows = array_merge($environment, $modules, $configuration, $general);

        return (new DataCommand())
            ->setTitle(self::TITLE)
            ->setHeader(['#1', '#2'])
            ->setRows($rows);
    }

    /**
     * @param  string $title
     * @param  int    $flag
     * @return array
     */
    private function getArrayData(string $title, int $flag): array
    {
        $contents = $this->getObContents($flag);

        return $this->getArrayItems($title, $contents);
    }

    /**
     * Prepare table rows.
     * @param  string $title
     * @param  string $contents
     * @return array
     */
    private function getArrayItems(string $title, string $contents): array
    {
        $result = [];
        $items = explode("\n", $contents);

        foreach ($items as $item) {
            if (!str_contains($item, ' => ')) {
                continue;
            }
            $exp = explode(' => ', $item);
            $exp = \array_slice($exp, 0, 2);
            $item = implode(' => ', $exp);
            $result[] = substr(trim($item), 0, 70);
        }

        $rows = array_chunk($result, 2);
        $values = (new MergeCellsData())->get($title, 2, 40);
        array_unshift($rows, $values);

        return $rows;
    }

    /**
     * Get phpinfo() content by flag.
     * @param  int         $flag
     * @return bool|string
     */
    private function getObContents(int $flag): bool|string
    {
        ob_start();
        phpinfo($flag);
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}
