<?php

namespace Admetrics\Magento\Model;

use Admetrics\Magento\Api\MetaRepositoryInterface;
use Admetrics\Magento\Api\Data\MetaInterface;
use Admetrics\Magento\Api\Data\MetaModuleInterface;
use Admetrics\Magento\Model\Data\Meta;
use Admetrics\Magento\Model\Data\MetaModule;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleListInterface;

class MetaRepository implements MetaRepositoryInterface
{
    public function __construct(
        protected ProductMetadataInterface $productMetadata,
        protected ModuleListInterface $moduleList,
    ) {
    }

    public function getMeta(): MetaInterface
    {
        return new Meta([
            MetaInterface::DATA_MAGENTO_VERSION => $this->productMetadata->getVersion(),
            MetaInterface::DATA_MAGENTO_EDITION => $this->productMetadata->getEdition(),
            MetaInterface::DATA_MODULES => array_map(function($module){
                return new MetaModule([
                    MetaModuleInterface::DATA_NAME => $module["name"],
                    MetaModuleInterface::DATA_SETUP_VERSION => $module["setup_version"],
                ]);
            }, $this->moduleList->getAll()),
        ]);
    }
}
