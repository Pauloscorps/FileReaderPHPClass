# FileReaderPHPClass
PHP Class to read CSV and TXT files

## What is it ?
The PHP class FileReader, is a simple library to read CSV and TXT files in PHP. 

## How to use it ?
You will find a "demo" directory showing examples for the both file types.
Here is an example for reading a CSV file :

`$file_reader = new FileReader($file_name, ';'); // Class construction for a ; separated file
$file_reader->setExcludedRows(array(0)); // Excluse first line (columns names)
$file_reader->getRows(); // Get rows from the file as a PHP array`

## Contributing
I would like to improve this library by adding more file types in the future. 
Feel free to contribute to the library development by giving file types you would want.

