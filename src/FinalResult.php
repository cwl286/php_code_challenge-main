<?php

require('src/utils/Reader.php');
require('src/parser/impl/SampleParserImpl.php');

class FinalResult
{
    function results($path)
    {

        $startIndex = 1;

        try {
            $reader = Reader::getInstance();
            $csv_arr = $reader->readCSV($path);

            $testDoc = new SampleParserImpl($csv_arr, $path);

            return [
                "filename" => $testDoc->getFileName(),
                "document" => $testDoc->getDocument(),
                "failure_code" => $testDoc->getFailureCode(),
                "failure_message" => $testDoc->getFailureMessage(),
                "records" => $testDoc->getRecords($startIndex)
            ];

        } catch (Exception $e) {
            echo 'Error Message: ' . $e->getMessage();
        }
    }
}

?>