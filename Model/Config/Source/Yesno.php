<?php

namespace Xigen\Announce\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Xigen\Announce\Helper\Data;

class Yesno implements OptionSourceInterface
{
    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => Data::ENABLED, 'label' => __('Yes')],
            ['value' => Data::DISABLED, 'label' => __('No')]
        ];
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        return [
            Data::DISABLED => __('No'),
            Data::ENABLED => __('Yes')
        ];
    }
}
