<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\Data;

use Xigen\Announce\Api\Data\MessageInterface;

class Message extends \Magento\Framework\Api\AbstractExtensibleObject implements MessageInterface
{
    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId()
    {
        return $this->_get(self::MESSAGE_ID);
    }

    /**
     * Set message_id
     * @param string $messageId
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setMessageId($messageId)
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\Announce\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Xigen\Announce\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\Announce\Api\Data\MessageExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get content
     * @return string|null
     */
    public function getContent()
    {
        return $this->_get(self::CONTENT);
    }

    /**
     * Set content
     * @param string $content
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get cssclass
     * @return string|null
     */
    public function getCssclass()
    {
        return $this->_get(self::CSSCLASS);
    }

    /**
     * Set cssclass
     * @param string $cssclass
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setCssclass($cssclass)
    {
        return $this->setData(self::CSSCLASS, $cssclass);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->_get(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId()
    {
        return $this->_get(self::GROUP_ID);
    }

    /**
     * Set group_id
     * @param string $groupId
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * Get sort
     * @return string|null
     */
    public function getSort()
    {
        return $this->_get(self::SORT);
    }

    /**
     * Set sort
     * @param string $sort
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setSort($sort)
    {
        return $this->setData(self::SORT, $sort);
    }
}
