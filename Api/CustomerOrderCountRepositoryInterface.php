<?php
namespace Admetrics\Magento\Api;

use Admetrics\Magento\Api\Data\CustomerOrderCountInterface;

interface CustomerOrderCountRepositoryInterface
{
    /**
     * @param int[] $customer_ids
     *
     * @return CustomerOrderCountInterface[]
     */
    public function getList(array $customer_ids): array;
}
