<?php
	class FormatController extends AppController{
		
		public function q1(){
			
            $this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
            
            if ($this->request->is('POST')){
                $this->redirect(
                    array(
                        'action' => 'show',
                        'type' =>  $this->request->data['Type']['type']
                    )
                );
            }	
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
        
        public function show()
        {
        }
        
		public function q1_detail(){

			$this->setFlash('Question: Please change Pop Up to mouse over (soft click)');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
	}