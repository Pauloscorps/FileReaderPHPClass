<?php

/**
 * FileReader
 * A simple class to read files (CSV, TXT)
 * 
 * Copyright (C) 2017  Pauline Ghiazza
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author 		Pauline Ghiazza
 * @license     GNU General Public License
 * @version    	1.0 [June 2015]
 * @link       	http://paulineghiazza.fr
 * @since      	Class available since release 1.0
 */ 


class FileReader {

	public $file_name;
	public $excluded_rows = array();

	private $_extension;
	private $_handle;
	private $_separator;

	/**
	 * __construct : Class constructor
	 *
	 * @param  string   $file_name 	The name of your file (its path if not the same folder)
	 * @param  string   $separator 	Values separator (for CSV files)
	 */
	public function __construct($file_name, $separator = ';') {
		$this->file_name = $file_name;
		$this->_setSeparator($separator);
		$this->_setExtension();
		$this->_openFile();
	}

	/**
	 * getRows : Main method to get rows
	 *
	 * @return array   $lines 	An associative array containing all lines
	 */
	public function getRows() {
		$lines = call_user_func_array(array($this, '_get'.strtoupper($this->_extension).'Rows'), array($this->excluded_rows));
		if($this->excluded_rows !== array()) $lines = $this->_unsetExcludedRows($lines);
		return $lines;
	}

	/**
	 * setExcludedRows : Main method to get rows (setter)
	 *
	 * @param  string  $rows 	An array containing the keys of the rows to exclude
	 */
	public function setExcludedRows($rows) {
		$this->excluded_rows = $rows;
	}

	/**
	 * _openFile : Main method to open a file
	 */
	private function _openFile() {
		$this->_handle = fopen($this->file_name, 'r');
	}

	/**
	 * _setExtension : Define extension (and so the type) of the file
	 */
	private function _setExtension() {
		$file_parts = explode('.', $this->file_name);
		$this->_extension = end($file_parts);
	}

	/**
	 * _setSeparator : Define the separator (for CSV file only) (setter)
	 */
	private function _setSeparator($separator) {
		$this->_separator = $separator;
	}

	/**
	 * _unsetExcludedRows : Method called if we want to exlude rows
	 *
	 * @param  string  $lines 	An array containing the original lines
	 * @return array   $lines 	An array contaning only the wanted lines
	 */
	private function _unsetExcludedRows($lines) {
		foreach($this->excluded_rows AS $row) {
			unset($lines[$row]);
		}
		return $lines;
	}

	/**
	 * _getCSVRows : Method called if the file is a CSV
	 *
	 * @return array   $lines 	An array contaning the lines of file
	 */
	private function _getCSVRows() {
		$lines = array();
		while(($data = fgets($this->_handle)) !== false) {
			$item = utf8_encode($data);
			$item = explode($this->_separator, $item);
			$lines[] = $item;
		}
		return $lines;
	}

	/**
	 * _getTXTRows : Method called if the file is a TXT
	 *
	 * @return array   $lines 	An array contaning the lines of file
	 */
	private function _getTXTRows() {
		$lines = array();
		while (!feof($this->_handle)){ 
        	$lines[] = trim(fgets($this->_handle, 9999)); 
     	} 
     	return $lines;
  	}
}
