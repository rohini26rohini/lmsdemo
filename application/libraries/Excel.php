<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/PHPExcel.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel extends PHPExcel{
    function __construct() {
    }

    public function read($file){
        return \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    }

    public function load($file){
        $inputFileType = ucfirst(substr($file, strrpos($file, '.') + 1));
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        return $reader->load($file);
    }
}


?>