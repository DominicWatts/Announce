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
        // phpcs:disable
        return [
            ['value' => Data::ORDERLY, 'label' => __(Data::ORDERLY_TEXT)],
            ['value' => Data::RANDOM, 'label' => __(Data::RANDOM_TEXT)]
        ];
        // phpcs:enable
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        // phpcs:disable
        return [
            Data::ORDERLY => __(Data::ORDERLY_TEXT),
            Data::RANDOM => __(Data::RANDOM_TEXT)
        ];
        // phpcs:enable
    }
}
