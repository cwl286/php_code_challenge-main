<?php

require 'src/utils/Singleton.php'; 

class Reader extends Singleton
{
    /**
     * Read CSV file 
     * @param string      $path     Path of CSV file
     * @return array    array of array
     */
    function readCSV($path): array
    {
        $file = fopen($path, "r");
        $arr = [];
        while (!feof($file)) {
            array_push($arr, fgetcsv($file));
        }

        fclose($file);

        return $arr;
    }
}

?>