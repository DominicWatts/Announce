<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel\Stats;

use Xigen\Announce\Api\Data\MessageInterface;
use Xigen\Announce\Api\Data\StatsInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'stats_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Xigen\Announce\Model\Stats::class,
            \Xigen\Announce\Model\ResourceModel\Stats::class
        );
    }

    /**
     * Set filter by message
     * @param mixed $message
     * @return \Xigen\Announce\Model\ResourceModel\Stats\Collection
     */
    public function addMessageIdFilter($message)
    {
        if (is_array($message)) {
            $this->addFieldToFilter(MessageInterface::MESSAGE_ID, ['in' => $message]);
        } elseif ($message instanceof \Xigen\Announce\Model\Message) {
            $this->addFieldToFilter(MessageInterface::MESSAGE_ID, $message->getMessageId());
        } else {
            $this->addFieldToFilter(MessageInterface::MESSAGE_ID, $message);
        }
        return $this;
    }

    /**
     * Set filter by group
     * @param $group
     * @return \Xigen\Announce\Model\ResourceModel\Stats\Collection
     */
    public function addGroupIdFilter($group)
    {
        if (is_array($group)) {
            $this->addFieldToFilter(GroupInterface::GROUP_ID, ['in' => $group]);
        } elseif ($group instanceof \Xigen\Announce\Model\Group) {
            $this->addFieldToFilter(GroupInterface::GROUP_ID, $group->getGroupId());
        } else {
            $this->addFieldToFilter(GroupInterface::GROUP_ID, $group);
        }
        return $this;
    }
}
