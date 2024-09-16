<?php
namespace Admetrics\Magento\Api;

use Admetrics\Magento\Api\Data\MetaInterface;

interface MetaRepositoryInterface
{
    /**
     * @return MetaInterface
     */
    public function getMeta(): MetaInterface;
}
