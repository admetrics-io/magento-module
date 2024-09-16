<?php
namespace Admetrics\Magento\Api\Data;

interface CustomerOrderCountInterface
{
    const DATA_CUSTOMER_ID = 'customer_id';
    const DATA_ORDER_COUNT = 'order_count';

    /**
     * @return int
     **/
    public function getCustomerId(): int;

    /**
     * @return int
     **/
    public function getOrderCount(): int;
}
