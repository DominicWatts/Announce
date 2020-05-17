<?php

namespace Xigen\Announce\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Xigen\Announce\Helper\Data;

class Sortby implements OptionSourceInterface
{
    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => Data::ORDERLY, 'label' => __('Orderly')],
            ['value' => Data::RANDOM, 'label' => __('Random')]
        ];
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        return [
            Data::ORDERLY => __('Orderly'),
            Data::RANDOM => __('Random')
        ];
    }
}
