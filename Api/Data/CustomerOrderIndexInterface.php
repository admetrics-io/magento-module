<?php
namespace Admetrics\Magento\Api\Data;

interface CustomerOrderIndexInterface
{
    const DATA_ORDER_ID = 'order_id';
    const DATA_ORDER_INDEX = 'order_index';

    /**
     * @return int
     **/
    public function getOrderId(): int;

    /**
     * @return int
     **/
    public function getOrderIndex(): int;
}
