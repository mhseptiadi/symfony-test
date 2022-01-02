<?php

namespace Console\Services;

use Console\Classes\OrderClass;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ParseService
{
    public function parse($url, $field = '', $sort = '', $save = '', $email = ''): void
    {
        echo "downloading $url \n";
        $jsonl = file_get_contents($url);
        $dataArr = explode("\n", $jsonl);
        $this->process($dataArr, $field, $sort, $save, $email);
    }

    private function process($dataArr, $field, $sort, $save, $email): void
    {
        echo "processing data \n";
        $dataMapped = array_map([$this, 'mapToOrder'], array_filter($dataArr));
        if ($field && $sort) {
            usort($dataMapped, $this->sort($field, $sort));
        }

        $file = 'out.csv';
        switch (true) {
            case $save === 'csv':
                $this->toCsv($dataMapped);
                break;
            case $save === 'xml':
                $this->toXml($dataMapped);
                $file = 'out.xml';
                break;
            case $save === 'jsonl':
                $this->toJsonl($dataMapped);
                $file = 'out.jsonl';
                break;
            default:
                $this->toCsv($dataMapped);
        }

        if ($email) {
            $emailService = new EmailService();
            $emailService->sendEmail($email, $file);
        }
    }

    private function sort($field, $sort)
    {
        return function ($a, $b) use ($field, $sort) {
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
        echo "save to csv \n";
        $out = 'out.csv';
        $fp = fopen($out, 'w');
        foreach ($dataMapped as $fields) {
            if ($fields->total_order_value > 0) {
                fputcsv($fp, (array) $fields);
            }
        }
        fclose($fp);
    }

    private function toJsonl($dataMapped): void
    {
        echo "save to jsonl \n";
        $out = 'out.jsonl';
        $fp = fopen($out, 'w');
        foreach ($dataMapped as $fields) {
            if ($fields->total_order_value > 0) {
                fputs($fp, json_encode($fields)."\n");
            }
        }
        fclose($fp);
    }

    private function toXml($dataMapped): void
    {
        $encoders = [new XmlEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $dataMapped = array_filter($dataMapped, function ($fields) {
            return $fields->total_order_value > 0;
        });

        $xmlContent = $serializer->serialize($dataMapped, 'xml');

        echo "save to xml \n";
        $out = 'out.xml';
        $fp = fopen($out, 'w');
        fputs($fp, $xmlContent);
        fclose($fp);
    }
}
