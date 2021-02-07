<?php

class FileUpload extends AppModel {
    public $validate = array(
        'name' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message'  => 'Alphanumeric characters only'
            ),
            'mustNotEmpty' => array(
                'rule' => 'notEmpty',
            )
        ),
        'email' => array(
            'mustNotEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a email.',
            ) ,
            'mustBeEmail' => array(
                'rule' => array(
                    'email'
                ) ,
                'message' => 'Please enter a valid email',
            ) ,
            'mustUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This email is already exists.',
            )
        )
    );
}