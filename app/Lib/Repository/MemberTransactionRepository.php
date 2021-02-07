<?php

class MemberTransactionRepository
{
    public function createMany($records)
    {
        return ClassRegistry::init('Member')->saveMany(
            $records,
            array('atomic' => 'true', 'deep' => true, 'validate' => false)
        );
    }
}