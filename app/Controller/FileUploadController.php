<?php

App::import('Lib/FileReaders', 'CsvReader');
App::import('Lib/Repository', 'FileUploadRepository');

class FileUploadController extends AppController {
    public $components = array('Session');

	public function index() {
		$this->set('title', __('File Upload Answer'));

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
    }
    
    public function upload() {

        if ($this->isValidUploadFile()) {
            $reader = CsvReader::make($this->request->data['FileUpload']['file']['tmp_name']);
            $data = $reader->readAll();

            if ($this->FileUpload->validateMany($data)) {
                $repository = new FileUploadRepository();
                $repository->createMany($data);

                $this->Session->setFlash('File uploaded successfully', 'flash_success');
            } else {
                $this->set('errors', $this->FileUpload->validationErrors);
                $this->Session->setFlash('File uploaded failed due to data validation', 'flash_error');
            } 
        }

        $this->redirect($this->referer());
    }

    private function isValidUploadFile()
    {
        $fileInfo =  $this->request->data['FileUpload']['file'];

        if ($fileInfo['type'] !== 'text/csv') {
            $this->Session->setFlash('File must be in csv format');
            return false;
        }
       
        return true;
    }
}