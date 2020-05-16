<?php

declare(strict_types=1);

namespace Xigen\Announce\Api\Data;

interface GroupInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const CSSCLASS = 'cssclass';
    const SORT_BY = 'sort_by';
    const GROUP_ID = 'group_id';
    const CREATED_AT = 'created_at';
    const STATUS = 'status';
    const SORT = 'sort';
    const EMAIL = 'email';
    const STORE_ID = 'store_id';
    const UPDATED_AT = 'updated_at';
    const NAME = 'name';

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId();

    /**
     * Set group_id
     * @param string $groupId
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setGroupId($groupId);

    /**
     * Get cssclass
     * @return string|null
     */
    public function getCssclass();

    /**
     * Set cssclass
     * @param string $cssclass
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setCssclass($cssclass);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\Announce\Api\Data\GroupExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Xigen\Announce\Api\Data\GroupExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\Announce\Api\Data\GroupExtensionInterface $extensionAttributes
    );

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setName($name);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setStatus($status);

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId();

    /**
     * Set store_id
     * @param string $storeId
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setStoreId($storeId);

    /**
     * Get email
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setEmail($email);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Xigen\Announce\Api\Data\GroupInterface
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get sort
     * @return string|null
     */
    public function getSort();

    /**
     * Set sort
     * @param string $sort
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setSort($sort);

    /**
     * Get sort_by
     * @return string|null
     */
    public function getSortBy();

    /**
     * Set sort_by
     * @param string $sortBy
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setSortBy($sortBy);
}
