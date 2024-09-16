<?php
namespace Admetrics\Magento\Api\Data;

interface MetaInterface
{
    const DATA_MAGENTO_VERSION = 'magento_version';
    const DATA_MAGENTO_EDITION = 'magento_edition';
    const DATA_MODULES = 'modules';

    /**
     * @return string
     **/
    public function getMagentoVersion(): string;

    /**
     * @return string
     **/
    public function getMagentoEdition(): string;

    /**
     * @return \Admetrics\Magento\Api\Data\MetaModuleInterface[]
     *
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function getModules(): array;
}
