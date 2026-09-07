<?php

namespace Admetrics\Magento\Block;

use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Throwable;

class Pixel extends Template
{
    public function __construct(
        Context $context,
        protected StoreManagerInterface $store_manager,
        protected ScopeConfigInterface $scope_config,
        protected Session $checkout_session,
        protected OrderRepositoryInterface $order_repository,
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
        $tracking_pixel = [];
        $product = null;
        $order_id = null;
        $order_number = null;
        $page_title = null;
        $store = null;
        $product_price = null;

        try {
            $tracking_pixel = json_decode(
                $this->scope_config->getValue("admetrics/tracking/pixel", ScopeInterface::SCOPE_STORES),
                true
            );

            $product_block = $this->getLayout()->getBlock('product.info');
            /** @var Product|null $product */
            $product = $product_block && method_exists($product_block, "getProduct") ? $product_block->getProduct() : null;
            $product_price = $product?->getPriceInfo()->getPrice('final_price')?->getValue();

            $order = $this->getSuccessOrder();
            $order_id = $order?->getEntityId();
            $order_number = $order?->getIncrementId();

            $page_title_block = $this->getLayout()->getBlock('page.main.title');
            $page_title = $page_title_block && method_exists($page_title_block, "getPageTitle") ? $page_title_block->getPageTitle() : null;

            $store = $this->store_manager->getStore();
        } /** @noinspection PhpUnusedLocalVariableInspection */ catch (Throwable $e) {
            // do nothing
        }

        return json_encode([
            "scripts" => [
                [
                    "inline" => json_encode([
                        "sid" => urlencode($tracking_pixel["sid"] ?? ""),
                        "oid" => urlencode($order_id ?? ""),
                        "cid" => "{CID}",
                        "on" => urlencode($order_number ?? ""),
                        "cim" => "",
                        "et" => "magento",
                        "en" => "",
                        "spt" => urlencode($product?->getCategory()?->getName() ?? ""),
                        "sptt" => urlencode($page_title ?? ""),
                        "sppt" => urlencode($product?->getName() ?? ""),
                        "spos" => "",
                        "scr" => urlencode($store?->getCurrentCurrencyCode() ?? ""),
                        "scpp" => urlencode($product_price ?? ""),
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
                        "data-ss-ob" => $tracking_pixel["ss_ob"] ?? "-",
                        "data-ss-ga" => $tracking_pixel["ss_ga"] ?? "-",
                    ],
                ]
            ],
        ]);
    }

    private function getSuccessOrder(): ?OrderInterface
    {
        $is_success_page = $this->getLayout()->getBlock('checkout.success')
            || $this->getRequest()->getFullActionName() === 'checkout_onepage_success';

        if (!$is_success_page) {
            return null;
        }

        try {
            $last_order = $this->checkout_session->getLastRealOrder();
            if ($last_order->getEntityId()) {
                return $last_order;
            }

            $last_order_id = $this->checkout_session->getLastOrderId();
            if ($last_order_id) {
                return $this->order_repository->get((int)$last_order_id);
            }
        } catch (Throwable) {
            return null;
        }

        return null;
    }
}
