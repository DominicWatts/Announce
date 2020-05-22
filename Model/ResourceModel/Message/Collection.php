<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel\Message;

use Xigen\Announce\Api\Data\MessageInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
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
     * Filter collection by group_id
     * @param int $groupId
     * @return $this
     */
    public function filterByGroupId($groupId = null)
    {
        if (empty($groupId)) {
            $this->addFieldToFilter(MessageInterface::GROUP_ID, ['null' => true]);
        } else {
            $this->addFieldToFilter(MessageInterface::GROUP_ID, $groupId);
        }
        return $this;
    }
}
