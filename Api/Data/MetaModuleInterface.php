<?php
namespace Admetrics\Magento\Api\Data;

interface MetaModuleInterface
{
    const DATA_NAME = 'name';
    const DATA_SETUP_VERSION = 'setup_version';

    /**
     * @return string
     **/
    public function getName(): string;

    /**
     * @return string|null
     **/
    public function getSetupVersion(): string|null;
}
