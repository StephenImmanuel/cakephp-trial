<?php

class Transaction extends AppModel{
    public $belongsTo = array('Member');
    public $hasMany = array(
        'TransactionItem' => array(
            'conditions' => array('TransactionItem.valid' => 1)
        )
    );

    public $validate = array(
        'total' => array(
            'rule' => 'validateTotal',
            'message' => 'Total does not tally. Please check subtotal and tax'
        )
    );

    public function validateTotal($total) {
        $subtotal = $this->data[$this->name]['subtotal'];
        $tax = $this->data[$this->name]['tax'];

        return current($total) == round($subtotal, 2) + round($tax, 2);
    }
}