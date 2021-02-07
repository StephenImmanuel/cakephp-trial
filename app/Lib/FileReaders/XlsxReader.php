<?php

App::import('Vendor', 'SimpleXLSX');

class XlsxReader
{
    private $file = null;
    private $errors = array();

    private function __construct($filename)
    {
        ini_set('auto_detect_line_endings', true);

        $this->file = SimpleXLSX::parse($filename);     
    }

    public function readLine()
    {
        foreach($this->file->rows() as $position => $rowData) { 
            if ($position === 0) {
                $headers = array_map(function($name) {
                    return strtolower(Inflector::slug($name));
                }, $rowData);

                continue;
            }

            yield array_combine($headers, $rowData);
        }
    }

    public function readAll()
    {
        $data = array();

        foreach ($this->readLine() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    public function errors()
    {
        return $this->errors;
    }

    private function validate()
    {
        return count($this->errors()) === 0;
    }

    public static function make($filename)
    {
       $file = new XlsxReader($filename);
       $file->validate();

       return $file;
    }
}