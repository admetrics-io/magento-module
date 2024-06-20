<?php

namespace Admetrics\Magento\Plugin\CustomerData;

use Magento\Customer\CustomerData\Customer as CustomerData;
use Magento\Customer\Helper\Session\CurrentCustomer;

class Customer
{
    public function __construct(protected CurrentCustomer $current_customer)
    {
    }

    public function afterGetSectionData(CustomerData $subject, $result)
    {
        $result['admetrics'] = [
            "id" => $this->current_customer->getCustomerId()
        ];
        return $result;
    }
}
