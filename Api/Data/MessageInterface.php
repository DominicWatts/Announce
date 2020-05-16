<?php

declare(strict_types=1);

namespace Xigen\Announce\Api\Data;

interface MessageInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const CSSCLASS = 'cssclass';
    const GROUP_ID = 'group_id';
    const CREATED_AT = 'created_at';
    const MESSAGE_ID = 'message_id';
    const STATUS = 'status';
    const SORT = 'sort';
    const CONTENT = 'content';
    const UPDATED_AT = 'updated_at';
    const NAME = 'name';

    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set message_id
     * @param string $messageId
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setMessageId($messageId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setName($name);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\Announce\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Xigen\Announce\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\Announce\Api\Data\MessageExtensionInterface $extensionAttributes
    );

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setContent($content);

    /**
     * Get cssclass
     * @return string|null
     */
    public function getCssclass();

    /**
     * Set cssclass
     * @param string $cssclass
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setCssclass($cssclass);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setStatus($status);

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId();

    /**
     * Set group_id
     * @param string $groupId
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setGroupId($groupId);

    /**
     * Get sort
     * @return string|null
     */
    public function getSort();

    /**
     * Set sort
     * @param string $sort
     * @return \Xigen\Announce\Api\Data\MessageInterface
     */
    public function setSort($sort);
}
