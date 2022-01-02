<?php

use PHPUnit\Framework\TestCase;
use Console\Services\OrderService;

class OrderServiceTest extends TestCase {
    public function testOrder() {
        $inputOrder = file_get_contents('./tests/data/order.json');
        $orderService = new OrderService(json_decode($inputOrder));
        $order = $orderService->getData();
        $this->assertEquals(1069, $order->order_id);
        $this->assertEquals("Tue, 12 Mar 2019 08:18:07 +0000", $order->order_datetime);
        $this->assertEquals(26.737437999999997, $order->total_order_value);
        $this->assertEquals(19.99, $order->average_unit_price);
        $this->assertEquals(1, $order->distinct_unit_count);
        $this->assertEquals(2, $order->total_units_count);
        $this->assertEquals("VICTORIA", $order->customer_state);
    }

    public function testInvalidOrder() {
        $this->expectExceptionMessage('Undefined property');
        $this->expectError();

        $orderService = new OrderService(json_decode('{}'));
        $orderService->getData();
    }
}
