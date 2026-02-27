<?php

namespace Admetrics\Magento\Model;

use Admetrics\Magento\Api\CustomerOrderIndexRepositoryInterface;
use Admetrics\Magento\Model\Data\CustomerOrderIndex;
use Magento\Framework\App\ResourceConnection;

class CustomerOrderIndexRepository implements CustomerOrderIndexRepositoryInterface
{
    public function __construct(protected ResourceConnection $resourceConnection) {}

    /**
     * @inheritdoc
     */
    public function getList(array $order_ids): array
    {
        // sanitize data
        $order_ids = array_filter(array_unique(array_map("intval", $order_ids)));

        if (empty($order_ids)) {
            return [];
        }

        $comma_separated_ids = implode(",", $order_ids);

        $connection = $this->resourceConnection->getConnection();
        $sales_order_table = $this->resourceConnection->getTableName('sales_order');
        $sql = "
        SELECT entity_id AS order_id, order_index FROM (
            SELECT entity_id, ROW_NUMBER() 
            OVER (PARTITION BY customer_id ORDER BY created_at, entity_id) AS order_index 
            FROM sales_order WHERE customer_id IN (
                SELECT DISTINCT customer_id FROM $sales_order_table WHERE entity_id IN ($comma_separated_ids)
            )
        ) AS p2 WHERE entity_id IN ($comma_separated_ids);
        ";
        $items = $connection->fetchAll($sql);

        return array_map(function ($item) {
            return new CustomerOrderIndex($item);
        }, $items);
    }
}
