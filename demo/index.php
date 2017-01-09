<?php

require '../FileReader.php';

/*************************************
*********** READING .TXT FILE*********
*************************************/
$file_txt = new FileReader('txt_file.txt');
$lines_txt = $file_txt->getRows();
var_dump($lines_txt);


/*************************************
********** READING .CSV FILE *********
*************************************/
$file_csv = new FileReader('csv_file.csv');
$file_csv->setExcludedRows(array(0));
$lines_csv = $file_csv->getRows();
var_dump($lines_csv);