<?php

namespace Console\Services;

use Console\Classes\OrderClass;

class ParseService
{
    public function parse($url): void {
        $jsonl = file_get_contents($url);
        $dataArr = explode("\n", $jsonl);
        $this->process($dataArr);
    }

    private function process($dataArr): void {
        $dataMapped = array_map(array($this, 'mapToOrder'), array_filter($dataArr));
        $this->toCsv($dataMapped);
//        print_r(($dataMapped));
    }

    private function mapToOrder($data): OrderClass {
        $jsonObject = json_decode($data);
        $order = new OrderService($jsonObject);
        return $order->getData();
    }

    private function toCsv($dataMapped): void {
        $out = 'out.csv';

        $fp = fopen($out, 'w');
        foreach ($dataMapped as $fields) {
            if ($fields->total_order_value > 0) {
                fputcsv($fp, (array) $fields);
            }
        }
        fclose($fp);
    }
}
