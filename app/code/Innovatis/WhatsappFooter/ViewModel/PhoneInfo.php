<?php

namespace Innovatis\WhatsappFooter\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class PhoneInfo implements ArgumentInterface
{
    private ScopeConfigInterface $scopeConfig;

    /**
     * PhoneInfo constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->scopeConfig->getValue('innovatis_whatsapp/innovatis_whatsapp_general/innovatis_whatsapp_general_active');
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->scopeConfig->getValue('innovatis_whatsapp/innovatis_whatsapp_general/innovatis_whatsapp_general_phone');
    }
}
