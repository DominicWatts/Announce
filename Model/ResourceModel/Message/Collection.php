<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel\Message;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Xigen\Announce\Api\Data\MessageInterface;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'message_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Xigen\Announce\Model\Message::class,
            \Xigen\Announce\Model\ResourceModel\Message::class
        );
    }

    /**
     * Set random messages order
     * @return $this
     */
    public function setRandomOrder()
    {
        $this->getConnection()->orderRand($this->getSelect());
        return $this;
    }

    /**
     * Set filter by item id
     * @param mixed $message
     * @return $this
     */
    public function addIdFilter($message)
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
     * Filter collection by group
     * @param \Xigen\Announce\Model\Group|int $group
     * @return $this
     */
    public function addGroupFilter($group)
    {
        if ($group instanceof \Xigen\Announce\Model\Group) {
            return $this->addGroupIdFilter($group->getGroupId());
        } elseif (is_int($group)) {
            return $this->addGroupIdFilter($group);
        }
        return $this;
    }

    /**
     * Filter collection by group_id
     * @param int $groupId
     * @return $this
     */
    public function addGroupIdFilter($groupId = null)
    {
        if (empty($groupId)) {
            $this->addFieldToFilter(MessageInterface::GROUP_ID, ['null' => true]);
        } else {
            $this->addFieldToFilter(MessageInterface::GROUP_ID, $groupId);
        }
        return $this;
    }

    /**
     * Filter collection by status
     * @param string $status
     * @return $this
     */
    public function addStatusFilter($status = null)
    {
        if (empty($status)) {
            $this->addFieldToFilter(MessageInterface::STATUS, ['null' => true]);
        } else {
            $this->addFieldToFilter(MessageInterface::STATUS, $status);
        }
        return $this;
    }
}
