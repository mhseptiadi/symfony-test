<?php

namespace Console\Classes;

class UnitClass
{
    private $items;
    private $average_unit_price;
    private $distinct_unit_count;
    private $total_units_count;

    function __construct($items) {
        $this->items = $items;
        $this->calculateAverageUnitPrice();
        $this->findDistinctUnitCount();
        $this->calculateTotalUnitCount();
    }

    public function getAverageUnitPrice(): float {
        return $this->average_unit_price;
    }

    public function getDistinctUnitCount(): float {
        return $this->distinct_unit_count;
    }

    public function getTotalUnitCount(): float {
        return $this->total_units_count;
    }

    private function calculateAverageUnitPrice(): void {
        $price = 0;
        $count = 0;
        foreach ($this->items as $item) {
            $price += $item->unit_price;
            $count++;
        }

        if ($count > 0) {
            $this->average_unit_price = $price / $count;
        } else {
            $this->average_unit_price = 0;
        }
    }

    function findDistinctUnitCount(): void {
        $items = array_map( function( $item ) { return $item->product->product_id; }, $this->items );
        $uniqueItems = array_unique( $items );
        $this->distinct_unit_count = count($uniqueItems);
    }

    private function calculateTotalUnitCount(): void
    {
        $count = 0;
        foreach ($this->items as $item) {
            $count += $item->quantity;
        }
        $this->total_units_count = $count;
    }
}
