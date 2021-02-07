<?php
    App::import('Lib/FileReaders', 'XlsxReader');
    App::import('Lib/Mappers', 'MemberTransactionMapper');
    App::import('Lib/Repository', 'MemberTransactionRepository');

	class MigrationController extends AppController{
        
        public function index() {
            $this->set('title', __('Data Migration to multiple Tables'));
        }

        public function migrate() {
            $this->loadModel('Member');

            $memberTransactions = array();
            $memberModel = new Member();

            $xlsxReader = XlsxReader::make($this->request->data['MigrationUpload']['file']['tmp_name']);
            $mapper = new MemberTransactionMapper();
            $repository = new MemberTransactionRepository();

            if ($this->isValidUploadFile()) {
                foreach($xlsxReader->readAll() as $recordNo => $row) {
                    list($member, $transaction, $transactionItem) = $mapper->map($row); 

                    $transaction['TransactionItem'][] = $transactionItem;
                    $member['Transaction'][] = $transaction;

                    if ($memberModel->validateAssociated($member,  array('deep' => true))) {
                        $memberTransactions[] = $member;
                    } else {
                        $errors['Line no:' .$recordNo+2] = $memberModel->validationErrors;
                    }
                }

                if ($memberTransactions) {
                    $repository->createMany($memberTransactions);
                }

                $this->Session->setFlash(
                    sprintf(
                        'Data migration summary errors: %d and success: %d ', 
                        count($errors), 
                        count($memberTransactions)
                    ),
                    'flash_success');
            }
    
            $this->redirect($this->referer());
        }
        
		public function q1(){
			
			// $this->setFlash('Question: Migration of data to multiple DB table');
				
			
			$this->set('title',__('Question: Migration of data to multiple DB table'));
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
        }
        
        private function isValidUploadFile()
        {
            $fileInfo =  $this->request->data['MigrationUpload']['file'];

            if ($fileInfo['type'] !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $this->Session->setFlash('File must be in xlsx format');
                return false;
            }
           
            return true;
        }
		
	}