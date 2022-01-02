<?php

namespace Console\Services;

use Console\Classes\OrderClass;

class ParseService
{
    public function parse($url, $field, $sort): void
    {
        $jsonl = file_get_contents($url);
        $dataArr = explode("\n", $jsonl);
        $this->process($dataArr, $field, $sort);
    }

    private function process($dataArr, $field, $sort): void
    {
        $dataMapped = array_map([$this, 'mapToOrder'], array_filter($dataArr));
        if ($field) {
            usort($dataMapped, $this->sort($field, $sort));
        }
        $this->toCsv($dataMapped);
    }

    private function sort($field, $sort)
    {
        return function($a, $b) use ($field, $sort) {
            if (!property_exists($a, $field)) {
                $field = 'order_id';
            }
            if ($sort === 'desc') {
                return strcmp($b->{$field}, $a->{$field});
            } else {
                return strcmp($a->{$field}, $b->{$field});
            }
        };
    }

    private function mapToOrder($data): OrderClass
    {
        $jsonObject = json_decode($data);
        $order = new OrderService($jsonObject);

        return $order->getData();
    }

    private function toCsv($dataMapped): void
    {
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
