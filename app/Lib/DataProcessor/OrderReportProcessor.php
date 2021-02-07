<?php
App::import('Lib/DataProcessor', 'ProcessorInterface');

class OrderReportProcessor implements ProcessorInterface
{
    public function __construct($orders, $portions)
    {
        $this->orders = $orders;
        $this->portions = $portions;
    }

    private function extractIngredients()
    {
        $itemsAndIngredients = array();

        foreach ($this->portions as $portion) {
            foreach($portion['PortionDetail'] as $portionDetail) { 
                $itemsAndIngredients[$portion['Portion']['item_id']][$portionDetail['Part']['name']] = $portionDetail['value'];
            }
        }

        return $itemsAndIngredients;
    }

    public function process()
    {
        $report = array();

        $itemsAndIngredients = $this->extractIngredients();

        foreach($this->orders as $order) {
            foreach($order['OrderDetail'] as $orderDetail) {
                foreach($itemsAndIngredients[$orderDetail['item_id']]  as $ingredient => $value) {
                    if (!isset($report[$order['Order']['name']][$ingredient])) {
                        $report[$order['Order']['name']][$ingredient] = null;
                    }
                    $report[$order['Order']['name']][$ingredient] += $orderDetail['quantity'] * $value;
                }
                ksort($report[$order['Order']['name']]);
            }
        }

        return $report;
    }
}