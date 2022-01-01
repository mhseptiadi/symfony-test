<?php

namespace Console\Services;

use Console\Classes\OrderClass;
use Console\Classes\DiscountClass;

class ParseService
{
    public function parse($url): void {
        $jsonl = file_get_contents($url);
        $dataArr = explode("\n", $jsonl);
        $this->process($dataArr);
    }

    private function process($dataArr): void {
//        foreach ($dataArr as $data) {
//
//            $dataMapped = $this->mapToOrder($data);
//            print_r($dataMapped);
//        }

        $dataMapped = array_map(array($this, 'mapToOrder'), $dataArr);
        print_r($dataMapped);
    }

    private function mapToOrder($data): OrderClass {
        $result = new OrderClass();
        if (!$data) {
            return $result;
        }

        $json = json_decode($data);
        $result->order_id =  $json->order_id;
        $result->order_datetime =  $json->order_date;

        $discount = new DiscountClass($json->items, $json->discounts);
        $result->total_order_value = $discount->getDiscountPrice();

//        print_r($result);

        return $result;
    }
}
