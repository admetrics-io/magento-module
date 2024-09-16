<?php

namespace Admetrics\Magento\Model\Data;

use Admetrics\Magento\Api\Data\CustomerOrderIndexInterface;
use Magento\Framework\DataObject;

class CustomerOrderIndex extends DataObject implements CustomerOrderIndexInterface
{
    public function getOrderId(): int
    {
        return $this->getData(self::DATA_ORDER_ID);
    }

    public function getOrderIndex(): int
    {
        return $this->getData(self::DATA_ORDER_INDEX);
    }
}
