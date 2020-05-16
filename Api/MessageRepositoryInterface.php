<?php

declare(strict_types=1);

namespace Xigen\Announce\Api;

interface MessageRepositoryInterface
{
    /**
     * Save Message
     * @param \Xigen\Announce\Api\Data\MessageInterface $message
     * @return \Xigen\Announce\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Xigen\Announce\Api\Data\MessageInterface $message
    );

    /**
     * Retrieve Message
     * @param string $messageId
     * @return \Xigen\Announce\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($messageId);

    /**
     * Retrieve Message matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Xigen\Announce\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Message
     * @param \Xigen\Announce\Api\Data\MessageInterface $message
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Xigen\Announce\Api\Data\MessageInterface $message
    );

    /**
     * Delete Message by ID
     * @param string $messageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($messageId);
}
