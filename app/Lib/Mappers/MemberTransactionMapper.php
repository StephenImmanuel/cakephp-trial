<?php

App::import('Lib/Mappers', 'MapperInterface');

class MemberTransactionMapper implements MappingInterface
{
    private static function memberMapping() {
        return array(
            'member_name' => 'name',
            'member_no' => 'no',
            'member_pay_type' => 'type',
            'member_company' => 'company',
            
        );
    }

    private static function transactionMapping() {
        return array(
            'member_name' => 'member_name',
            'member_pay_type' => 'member_paytype',
            'payment_by' => 'payment_method',
            'member_company' => 'member_company',
            'date' => 'date',
            'ref_no' => 'ref_no',
            'receipt_no' => 'receipt_no',
            'batch_no' => 'batch_no',
            'cheque_no' => 'cheque_no',
            'renewal_year' => 'renewal_year',
            'subtotal' => 'subtotal',
            'totaltax' => 'tax',
            'total' => 'total',
            'year' => function($data) {
                return isset($data['date']) ? date('Y', strtotime($data['date'])) : null;
            },
            'month' => function($data) {
                return isset($data['date']) ? date('m', strtotime($data['date'])) : null;
            }
        );
    }

    private static function transactionItemMapping() {
        return array(
            'payment_description' => 'description'
        );
    }

    private function mapFieldNameAndValue($data, $mappingFields)
    {
        $tmp = array();

        foreach ($mappingFields as $oldName => $newName) {

            if ($newName instanceof Closure) {
                $tmp[$oldName] = $newName($data) ;
            } else {
                $tmp[$newName] = isset($data[$oldName]) ? $data[$oldName] : null ;
            }
        }

        return $tmp;
    }

    public function map($data)
    {
        $mapped = array();

        $mappers = array(
            self::memberMapping(),
            self::transactionMapping(),
            self::transactionItemMapping()
        );

        foreach ($mappers as $mapper) {
            $mapped[] = $this->mapFieldNameAndValue($data, $mapper);
        }

        return $mapped;
    }
}