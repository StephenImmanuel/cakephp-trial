<?php
App::uses('File', 'Utility');

class CsvReader
{
    private $file = null;
    private $errors = array();

    private function __construct($filename)
    {
        ini_set('auto_detect_line_endings', true);

        $this->file = new SplFileObject($filename);
        $this->file->setFlags(SplFileObject::READ_CSV);      
    }

    public function readLine()
    {
        $this->file->rewind();

        foreach ($this->file as $position => $rowData) {
            if($position === 0) {
                $headers = array_map('strtolower', $rowData);
                continue;
            }

            if (count($headers) !== count($rowData)) {
                $this->errors[] = sprintf(
                    'Line %d Item count does not match with number of columns', $position+1
                );

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
       $file = new CsvReader($filename);
       $file->validate();

       return $file;
    }
}