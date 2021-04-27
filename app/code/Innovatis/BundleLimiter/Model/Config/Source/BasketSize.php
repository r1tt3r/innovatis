<?php

namespace Innovatis\BundleLimiter\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class BasketSize extends AbstractSource
{
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '', 'label' => __('Please Select the size')],
                ['value' => '1', 'label' => __('Small')],
                ['value' => '2', 'label' => __('Average')],
                ['value' => '3', 'label' => __('Big')],
            ];
        }
        return $this->_options;
    }

    /**
     * Get text of the option value
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionValue($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
