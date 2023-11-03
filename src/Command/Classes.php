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

use PhacMan\ClassExplorer\Explorer;
use PhacMan\ConsoleTable\Helper\TableSeparator;
use PhacMan\ProjectAnalysis\Data\DataCommand;
use PhacMan\ProjectAnalysis\Data\DataCommandInterface;
use PhacMan\ProjectAnalysis\Util\LoadClasses;
use PhacMan\ProjectAnalysis\Util\MergeCellsData;

class Classes implements CommandInterface
{
    const TITLE = 'Exploring src/tests classes';

    /**
     * @return DataCommandInterface
     */
    public function run(): DataCommandInterface
    {
        $dirProject = rtrim(current(explode('vendor', COMPOSER_AUTOLOAD_PATH)), '/');
        $dirSrc = $dirProject.'/src';
        $dirTests = $dirProject.'/tests';

        $pathsSrc = (new LoadClasses())->load($dirSrc);
        $pathsTests = (new LoadClasses())->load($dirTests);

        [$headerSrc, $rowsSrc] = $this->getData($pathsSrc);
        [, $rowsTests] = $this->getData($pathsTests);
        $colspan = \count($headerSrc);
        $repeat = 20;

        $sectionSrc = (new MergeCellsData())->get('src/ classes', $colspan, $repeat);
        array_unshift($rowsSrc, $sectionSrc);

        $sectionTests = (new MergeCellsData())->get('tests/ classes', $colspan, $repeat);
        array_unshift($rowsTests, $sectionTests);

        $rowsSrc[] = new TableSeparator();
        $rows = array_merge([], $rowsSrc, $rowsTests);

        return (new DataCommand())
            ->setTitle(self::TITLE)
            ->setHeader($headerSrc)
            ->setRows($rows);
    }

    /**
     * @param  array         $paths
     * @return array|array[]
     */
    private function getData(array $paths): array
    {
        if (!\count($paths)) {
            return [[], []];
        }
        $data = [];

        foreach ($paths as $path) {
            $class = new Explorer($path);

            $type = $class->getClassType();
            $methods = $class->getMethods();
            $public = $this->getFilter($methods, 'public ');
            $protected = $this->getFilter($methods, 'protected ');
            $private = $this->getFilter($methods, 'private ');

            $data[$type]['type'] = $type;
            $data[$type]['qty'] = ($data[$type]['qty'] ?? 0) + 1;

            $data[$type]['constants'] = $this->counter($data, $type, 'constants', $class->getConstants());
            $data[$type]['properties'] = $this->counter($data, $type, 'properties', $class->getProperties());
            $data[$type]['methods_total'] = $this->counter($data, $type, 'methods_total', $methods);
            $data[$type]['public_methods'] = $this->counter($data, $type, 'public_methods', $public);
            $data[$type]['protected_methods'] = $this->counter($data, $type, 'protected_methods', $protected);
            $data[$type]['private_methods'] = $this->counter($data, $type, 'private_methods', $private);
        }

        ksort($data);

        $header = array_keys(current($data));
        $rows = [];
        foreach ($data as $items) {
            $rows[] = $items;
        }

        return [$header, $rows];
    }

    /**
     * @param  array     $data
     * @param  string    $type
     * @param  string    $key
     * @param  array     $items
     * @return int|mixed
     */
    private function counter(array $data, string $type, string $key, array $items): mixed
    {
        return ($data[$type][$key] ?? 0) + \count($items);
    }

    /**
     * @param  array  $items
     * @param  string $search
     * @return array
     */
    private function getFilter(array $items, string $search): array
    {
        return array_filter($items, function (string $item) use ($search) {
            return str_contains($item, $search);
        });
    }
}
