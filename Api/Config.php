<?php
namespace Admetrics\Magento\Api;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    public function __construct(
        protected WriterInterface $config_writer,
        protected TypeListInterface $cache_type_list,
        protected StoreManagerInterface $store_manager,
    ) {
    }

    /**
     * @param bool|null $tracking_enabled
     * @param string|null $tracking_pixel
     *
     * @return bool
     *
     * @throws NoSuchEntityException
     */
    public function updateConfig(bool $tracking_enabled = null, string $tracking_pixel = null): bool
    {
        $shop_id = $this->store_manager->getStore()->getId();

        if ($tracking_enabled !== null) {
            $this->config_writer->save("admetrics/tracking/enabled", $tracking_enabled, "stores", $shop_id);
        }
        if ($tracking_pixel !== null) {
            $this->config_writer->save("admetrics/tracking/pixel", json_encode(json_decode($tracking_pixel)), "stores", $shop_id);
        }

        $this->cache_type_list->cleanType(\Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER);
        $this->cache_type_list->cleanType(\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER);

        return true;
    }
}
