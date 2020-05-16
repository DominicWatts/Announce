<?php

declare(strict_types=1);

namespace Xigen\Announce\Api;

interface GroupRepositoryInterface
{
    /**
     * Save Group
     * @param \Xigen\Announce\Api\Data\GroupInterface $group
     * @return \Xigen\Announce\Api\Data\GroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Xigen\Announce\Api\Data\GroupInterface $group
    );

    /**
     * Retrieve Group
     * @param string $groupId
     * @return \Xigen\Announce\Api\Data\GroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($groupId);

    /**
     * Retrieve Group matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Xigen\Announce\Api\Data\GroupSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Group
     * @param \Xigen\Announce\Api\Data\GroupInterface $group
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Xigen\Announce\Api\Data\GroupInterface $group
    );

    /**
     * Delete Group by ID
     * @param string $groupId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($groupId);
}
