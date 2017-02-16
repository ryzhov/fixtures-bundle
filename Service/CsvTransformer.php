<?php

namespace Ryzhov\Bundle\FixturesBundle\Service;

use Keboola\Csv\CsvFile;

class CsvTransformer
{
    /**
     * @param string $path
     * @param string $nullValue
     * @return array
     */
    public function process($path, $nullValue = 'NULL')
    {
        $csvFile = new CsvFile($path, CsvFile::DEFAULT_DELIMITER, CsvFile::DEFAULT_ENCLOSURE, '\\');
        
        $head = null;
        $i = 0;
        
        foreach($csvFile as $row) {
            if (null === $head) {
                $head = array_map(function($item) { return str_replace(' ', '_', strtolower(trim($item))); }, $row);
                continue;
            }

            if (count($row) < count($head)) {
                continue;
            }

            $fixtures[$i] = array();
            $j = 0;
            
            foreach($row as $item) {
                if (isset($head[$j])) {
                    $fixtures[$i][$head[$j]] = $item === $nullValue ? null : trim($item);
                }
                ++$j;
            }
            
            ++$i;
        }

        return $fixtures;
    }
    
    /**
     * @param string $path
     * @param array $fixtures
     * @return void
     */
    public function export($path, array $fixtures)
    {
        $csvFile = new CsvFile($path);

        $csvFile->writeRow(array_keys($fixtures[0]));
        
        foreach ($fixtures as $row) {
            $csvFile->writeRow($row);
        }
    }
}