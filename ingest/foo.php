<?php
    // If you need to parse XLS files, include php-excel-reader
    // require('php-excel-reader/excel_reader2.php');

    // require('SpreadsheetReader.php');

    // $Reader = new SpreadsheetReader('/vagrant/data/Series 101 - 110/Series_101_vtls004569620/File_101-1_vtls004634468.xlsx');
    // foreach ($Reader as $Row)
    // {
    //     print_r($Row);
    // }

$di = new RecursiveDirectoryIterator('/vagrant/data');
foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
  // echo gettype($filename);
    echo "\n$filename";
    if(is_dir($filename)) {
      echo " - not a file";

    }else{
      echo " - is a file";
    }
}