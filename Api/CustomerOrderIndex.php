<?php

namespace Admetrics\Magento\Api;

use Magento\Framework\App\PlainTextRequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Webapi\Request;

class CustomerOrderIndex
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    public function __construct(Request $request, ResourceConnection $resourceConnection)
    {
        $this->request = $request;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @return array
     */
    public function post(): array
    {
        $ids = array_filter(array_map("intval", json_decode($this->request->getContent())));

        if (empty($ids)) {
            return [];
        }

        $comma_separated_ids = implode(",", $ids);

        $connection = $this->resourceConnection->getConnection();
        $sql = "
        SELECT entity_id AS order_id, order_index FROM (
            SELECT entity_id, ROW_NUMBER() OVER (PARTITION BY customer_id ORDER BY created_at, entity_id) AS order_index FROM (
                SELECT entity_id, customer_id, created_at FROM sales_order WHERE entity_id IN ($comma_separated_ids)
            ) AS p1
        ) AS p2 WHERE entity_id IN ($comma_separated_ids);
        ";
        return $connection->fetchAll($sql);
    }
}
