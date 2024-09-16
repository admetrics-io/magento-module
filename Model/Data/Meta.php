<?php

namespace Admetrics\Magento\Model\Data;

use Admetrics\Magento\Api\Data\MetaInterface;
use Magento\Framework\DataObject;

class Meta extends DataObject implements MetaInterface
{
    public function getMagentoVersion(): string
    {
        return $this->getData(self::DATA_MAGENTO_VERSION);
    }

    public function getMagentoEdition(): string
    {
        return $this->getData(self::DATA_MAGENTO_EDITION);
    }

    public function getModules(): array
    {
        return $this->getData(self::DATA_MODULES);
    }
}
