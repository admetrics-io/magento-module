<?php

namespace Admetrics\Magento\Model\Data;

use Admetrics\Magento\Api\Data\CustomerOrderCountInterface;
use Magento\Framework\DataObject;

class CustomerOrderCount extends DataObject implements CustomerOrderCountInterface
{
    public function getCustomerId(): int
    {
        return $this->getData(self::DATA_CUSTOMER_ID);
    }

    public function getOrderCount(): int
    {
        return $this->getData(self::DATA_ORDER_COUNT);
    }
}
