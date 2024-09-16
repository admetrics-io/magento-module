<?php

namespace Admetrics\Magento\Model;

use Admetrics\Magento\Model\Data\CustomerOrderCount;
use Admetrics\Magento\Api\CustomerOrderCountRepositoryInterface;
use Magento\Framework\App\ResourceConnection;

class CustomerOrderCountRepository implements CustomerOrderCountRepositoryInterface
{
    public function __construct(protected ResourceConnection $resourceConnection) {}

    /**
     * @inheritdoc
     */
    public function getList(array $customer_ids): array
    {
        // sanitize data
        $customer_ids = array_filter(array_unique(array_map("intval", $customer_ids)));

        if (empty($customer_ids)) {
            return [];
        }

        $comma_separated_ids = implode(",", $customer_ids);

        $connection = $this->resourceConnection->getConnection();
        $sql = "SELECT customer_id, COUNT(*) AS order_count FROM sales_order WHERE customer_id IN ($comma_separated_ids) GROUP BY customer_id";
        $items = $connection->fetchAll($sql);

        return array_map(function ($item) {
            return new CustomerOrderCount($item);
        }, $items);
    }
}
