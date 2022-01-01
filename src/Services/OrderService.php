<?php

namespace Console\Services;

use Console\Classes\DiscountClass;
use Console\Classes\OrderClass;
use Console\Classes\UnitClass;

class OrderService
{
    private $order;
    private $jsonObject;

    function __construct($jsonObject) {
        $this->order = new OrderClass();
        $this->jsonObject = $jsonObject;
        $this->map();
    }

    public function getData(): OrderClass {
        return $this->order;
    }

    public function getDataArray(): OrderClass {
        return $this->order;
    }

    private function map(): void {
        if (!$this->jsonObject) {
            return;
        }
        $this->order->order_id =  $this->jsonObject->order_id;
        $this->order->order_datetime = $this->jsonObject->order_date;
        $this->calculateDiscount();
        $this->getUnitDetail();
        $this->order->customer_state = $this->jsonObject->customer->shipping_address->state;
    }

    private function calculateDiscount(): void {
        $discount = new DiscountClass($this->jsonObject->items, $this->jsonObject->discounts);
        $this->order->total_order_value = $discount->getDiscountPrice();
    }

    private function getUnitDetail(): void {
        $unit = new UnitClass($this->jsonObject->items);
        $this->order->average_unit_price = $unit->getAverageUnitPrice();
        $this->order->distinct_unit_count = $unit->getDistinctUnitCount();
        $this->order->total_units_count = $unit->getTotalUnitCount();
    }
}
