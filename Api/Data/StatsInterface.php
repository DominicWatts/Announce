<?php

declare(strict_types=1);

namespace Xigen\Announce\Api\Data;

interface StatsInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const FIRST_IMPRESSION_DATE = 'first_impression_date';
    const LAST_IMPRESSION_DATE = 'last_impression_date';
    const IMPRESSIONS = 'impressions';
    const STATS_ID = 'stats_id';
    const GROUP_ID = 'group_id';
    const MESSAGE_ID = 'message_id';

    /**
     * Get stats_id
     * @return string|null
     */
    public function getStatsId();

    /**
     * Set stats_id
     * @param string $statsId
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setStatsId($statsId);

    /**
     * Get group_id
     * @return string|null
     */
    public function getGroupId();

    /**
     * Set group_id
     * @param string $groupId
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setGroupId($groupId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\Announce\Api\Data\StatsExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Xigen\Announce\Api\Data\StatsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\Announce\Api\Data\StatsExtensionInterface $extensionAttributes
    );

    /**
     * Get impressions
     * @return string|null
     */
    public function getImpressions();

    /**
     * Set impressions
     * @param string $impressions
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setImpressions($impressions);

    /**
     * Get first_impression_date
     * @return string|null
     */
    public function getFirstImpressionDate();

    /**
     * Set first_impression_date
     * @param string $firstImpressionDate
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setFirstImpressionDate($firstImpressionDate);

    /**
     * Get last_impression_date
     * @return string|null
     */
    public function getLastImpressionDate();

    /**
     * Set last_impression_date
     * @param string $lastImpressionDate
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setLastImpressionDate($lastImpressionDate);

    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set message_id
     * @param string $messageId
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setMessageId($messageId);
}
