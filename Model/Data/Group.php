<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\Data;

use Xigen\Announce\Api\Data\GroupInterface;

class Group extends \Magento\Framework\Api\AbstractExtensibleObject implements GroupInterface
{
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setCssclass($cssclass)
    {
        return $this->setData(self::CSSCLASS, $cssclass);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\Announce\Api\Data\GroupExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Xigen\Announce\Api\Data\GroupExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\Announce\Api\Data\GroupExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * Set store_id
     * @param string $storeId
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Get email
     * @return string|null
     */
    public function getEmail()
    {
        return $this->_get(self::EMAIL);
    }

    /**
     * Set email
     * @param string $email
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
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
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setSort($sort)
    {
        return $this->setData(self::SORT, $sort);
    }

    /**
     * Get sort_by
     * @return string|null
     */
    public function getSortBy()
    {
        return $this->_get(self::SORT_BY);
    }

    /**
     * Set sort_by
     * @param string $sortBy
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setSortBy($sortBy)
    {
        return $this->setData(self::SORT_BY, $sortBy);
    }

    /**
     * Get customer_group_id
     * @return string|null
     */
    public function getCustomerGroupId()
    {
        return $this->_get(self::CUSTOMER_GROUP_ID);
    }

    /**
     * Set customer_group_id
     * @param string $customerGroupId
     * @return \Xigen\Announce\Api\Data\GroupInterface
     */
    public function setCustomerGroupId($customerGroupId)
    {
        return $this->setData(self::CUSTOMER_GROUP_ID, $customerGroupId);
    }
}
