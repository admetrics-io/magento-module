<?php

namespace Admetrics\Magento\Block;

use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class Pixel extends Template
{
    public function __construct(
        Context $context,
        protected \Magento\Store\Model\StoreManagerInterface $store_manager,
        protected ScopeConfigInterface $scope_config,
        protected Session $checkout_session,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function isTrackingEnabled(): bool
    {
        return (bool)$this->scope_config->getValue("admetrics/tracking/enabled", ScopeInterface::SCOPE_STORES);
    }

    public function getPixelJson(): string
    {
        $tracking_pixel = json_decode(
            $this->scope_config->getValue("admetrics/tracking/pixel", ScopeInterface::SCOPE_STORES),
            true
        );

        $product_block = $this->getLayout()->getBlock('product.info');
        /** @var Product|null $product */
        $product = $product_block ? $product_block->getProduct() : null;

        $order_block = $this->getLayout()->getBlock('checkout.success');
        if ($order_block) {
            $order_id = $this->checkout_session->getLastRealOrder()?->getId() ?? null;
        }

        return json_encode([
            "scripts" => [
                [
                    "inline" => json_encode([
                        "sid" => urlencode($tracking_pixel["sid"] ?? ""),
                        "oid" => urlencode($order_id ?? ""),
                        "cid" => "{CID}",
                        "on" => "",
                        "cim" => "",
                        "et" => "magento",
                        "en" => "",
                        "spt" => urlencode($product?->getCategory()?->getName() ?? ""),
                        "sptt" => urlencode($this->getLayout()->getBlock('page.main.title')->getPageTitle() ?? ""),
                        "sppt" => urlencode($product?->getName() ?? ""),
                        "spos" => "",
                        "scr" => urlencode($this->store_manager->getStore()->getCurrentCurrencyCode()),
                        "scpp" => urlencode($product?->getPriceInfo()->getPrice('final_price')->getValue() ?? ""),
                        "sctp" => "{SCTP}",
                        "sss" => "",
                        "spi" => urlencode($product?->getSku() ?? ""),
                        "sci" => "",
                        "scc" => "",
                        "sca" => ""
                    ]),
                    "attributes" => [
                        "id" => "js-app-admq-data",
                        "type" => "application/json",
                    ]
                ],
                [
                    "attributes" => [
                        "id" => "js-app-admq-script",
                        "type" => "application/javascript",
                        "async" => true,
                        "src" => $tracking_pixel["src"] ?? "-",
                        "data-endpoint" => $tracking_pixel["endpoint"] ?? "-",
                        "data-cn" => $tracking_pixel["cn"] ?? "-",
                        "data-cv" => $tracking_pixel["cv"] ?? "-",
                        "data-cv2" => $tracking_pixel["cv2"] ?? "-",
                        "data-pa-vendor" => $tracking_pixel["pa_vendor"] ?? "-",
                        "data-pa-mpid" => $tracking_pixel["pa_mpid"] ?? "-",
                        "data-ss-mpid" => $tracking_pixel["ss_mpid"] ?? "-",
                        "data-ss-tkpid" => $tracking_pixel["ss_tkpid"] ?? "-",
                        "data-ss-scpid" => $tracking_pixel["ss_scpid"] ?? "-",
                    ],
                ]
            ],
        ]);
    }
}
