<?php
namespace Admetrics\Magento\Api;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Webapi\Request;

class CustomerOrderCount
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
        $sales_order_table = $this->resourceConnection->getTableName('sales_order');
        $sql = "SELECT customer_id, COUNT(*) AS order_count FROM $sales_order_table WHERE customer_id IN ($comma_separated_ids) GROUP BY customer_id";
        return $connection->fetchAll($sql);
    }
}
