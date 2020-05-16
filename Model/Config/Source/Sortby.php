<?php

namespace Xigen\Announce\Model\Config\Source;

class Sortby implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Orderly')], ['value' => 2, 'label' => __('Random')]];
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        return [1 => __('Orderly'), 2 => __('Random')];
    }
}
