<?php

namespace app\Parser;

ini_set('display_errors',1);
error_reporting(E_ALL);

class ParseCSV
{
    public static function parse(): ?array
    {
        $array = null;
        $handle = fopen("data.csv", "r");
        if (($handle) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $array[] = [
                    'name' => $data[0],
                    'price' => $data[1],
                    'image' => $data[2]
                ];
            }

            fclose($handle);
        }
        return $array;
    }
}