<?php

namespace Innovatis\BundleLimiter\Observer;

use Magento\Catalog\Model\Product\Type;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class LimitQtyBundle implements ObserverInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * LimitQtyBoundle constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var $item \Magento\Quote\Model\Quote\Item */
        $item           = $observer->getEvent()->getQuoteItem();
        $totalQty       = 0;
        $productType    = $item->getProduct()->getTypeId();

        if ($productType == Type::TYPE_BUNDLE) {
            foreach ($item->getQtyOptions() as $qtyChildProduct) {
                $totalQty += (int) $qtyChildProduct->getValue();
            }
        }

        $basketActive   = $item->getProduct()->getData('basket_active');
        $basketName     = strtolower($item->getProduct()->getAttributeText('basket_size'));
        $basketSize     = 0;

        switch ($basketName) {
            case 'grande':
                $basketSize = 12;
                break;
            case 'média':
                $basketSize = 8;
                break;
            case 'pequena':
                $basketSize = 5;
                break;
        }

        if ($basketActive) {
            if ($basketSize && $basketSize !== $totalQty) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('For basket of size %1 it is necessary to add %2 products.', $basketName, $basketSize)
                );
            }
        }

        return true;
    }
}
