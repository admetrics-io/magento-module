<?php
namespace Admetrics\Magento\Api;

use Admetrics\Magento\Api\Data\CustomerOrderIndexInterface;

interface CustomerOrderIndexRepositoryInterface
{
    /**
     * @param int[] $order_ids
     *
     * @return CustomerOrderIndexInterface[]
     */
    public function getList(array $order_ids): array;
}
