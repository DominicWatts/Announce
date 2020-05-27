<?php

namespace Xigen\Announce\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Helper\Fetch;

class Message implements OptionSourceInterface
{
    /**
     * @var Fetch
     */
    protected $fetchHelper;

    /**
     * Group constructor.
     * @param Fetch $fetchHelper
     */
    public function __construct(
        Fetch $fetchHelper
    ) {
        $this->fetchHelper = $fetchHelper;
    }

    /**
     * Get messages - sort by name
     * @return GroupInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getMessages()
    {
        return $this->fetchHelper->getMessages(false);
    }

    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        $return = [
            [
                'value' => '',
                'label' => __('Please select')
            ]
        ];

        $items = $this->getMessages(true);
        foreach ($items as $item) {
            $return[] = [
                'value' => $item->getMessageId(),
                'label' => __(
                    '[%1] %2 [%3]',
                    $item->getMessageId(),
                    $item->getName(),
                    $item->getStatus() == Data::ENABLED ? __(Data::ENABLED_TEXT) : __(Data::DISABLED_TEXT) // phpcs:ignore
                )
            ];
        }
        return $return;
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        $items = $this->getMessages(true);
        $return = [];
        foreach ($items as $item) {
            $return[$item->getMessageId()] = $item->getName();
        }
        return $return;
    }
}
