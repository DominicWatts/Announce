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
            ['value' => Data::ENABLED, 'label' => __(Data::ENABLED_TEXT)],
            ['value' => Data::DISABLED, 'label' => __(Data::DISABLED_TEXT)]
        ];
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        return [
            Data::DISABLED => __(Data::ENABLED_TEXT),
            Data::ENABLED => __(Data::DISABLED_TEXT)
        ];
    }
}
