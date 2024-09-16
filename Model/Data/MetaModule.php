<?php

namespace Admetrics\Magento\Model\Data;

use Admetrics\Magento\Api\Data\MetaModuleInterface;
use Magento\Framework\DataObject;

class MetaModule extends DataObject implements MetaModuleInterface
{
    public function getName(): string
    {
        return $this->getData(self::DATA_NAME);
    }

    public function getSetupVersion(): string|null
    {
        return $this->getData(self::DATA_SETUP_VERSION);
    }
}
