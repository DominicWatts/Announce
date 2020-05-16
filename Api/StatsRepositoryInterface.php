<?php

declare(strict_types=1);

namespace Xigen\Announce\Api;

interface StatsRepositoryInterface
{
    /**
     * Save Stats
     * @param \Xigen\Announce\Api\Data\StatsInterface $stats
     * @return \Xigen\Announce\Api\Data\StatsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Xigen\Announce\Api\Data\StatsInterface $stats
    );

    /**
     * Retrieve Stats
     * @param string $statsId
     * @return \Xigen\Announce\Api\Data\StatsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($statsId);

    /**
     * Retrieve Stats matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Xigen\Announce\Api\Data\StatsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Stats
     * @param \Xigen\Announce\Api\Data\StatsInterface $stats
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Xigen\Announce\Api\Data\StatsInterface $stats
    );

    /**
     * Delete Stats by ID
     * @param string $statsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($statsId);
}
