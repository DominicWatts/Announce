<?php

namespace Xigen\Announce\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Helper\Fetch;

class Group implements OptionSourceInterface
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
     * Get groups - sort by name
     * @return GroupInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getGroups()
    {
        return $this->fetchHelper->getGroups(false);
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

        $items = $this->getGroups();
        foreach ($items as $item) {
            $return[] = [
                'value' => $item->getGroupId(),
                'label' => __(
                    '[%1] %2 [%3]',
                    $item->getGroupId(),
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
        $items = $this->getGroups();
        $return = [];
        foreach ($items as $item) {
            $return[$item->getGroupId()] = $item->getName();
        }
        return $return;
    }
}
