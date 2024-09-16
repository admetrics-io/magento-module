<?php
namespace Admetrics\Magento\Api;

use Admetrics\Magento\Api\Data\MetaInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\Module\ModuleResource;
use Magento\Store\Model\StoreManagerInterface;

class Meta
{
    public function __construct(
        protected ProductMetadataInterface $productMetadata,
        protected ModuleListInterface $moduleList,
        protected ModuleResource $moduleResource,
        protected ScopeConfigInterface $scopeConfig,
        protected JsonFactory $jsonFactory,
    ) {
    }

    /**
     * @return MetaInterface
     */
    public function get(): MetaInterface
    {
        return [
            "magento_version" => $this->productMetadata->getVersion(),
            "magento_edition" => $this->productMetadata->getEdition(),
            "modules" => $this->moduleList->getAll(),
        ];
    }
}
