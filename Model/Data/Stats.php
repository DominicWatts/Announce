<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\Data;

use Xigen\Announce\Api\Data\StatsInterface;

class Stats extends \Magento\Framework\Api\AbstractExtensibleObject implements StatsInterface
{
    /**
     * Get stats_id
     * @return string|null
     */
    public function getStatsId()
    {
        return $this->_get(self::STATS_ID);
    }

    /**
     * Set stats_id
     * @param string $statsId
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setStatsId($statsId)
    {
        return $this->setData(self::STATS_ID, $statsId);
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
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setGroupId($groupId)
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Xigen\Announce\Api\Data\StatsExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Xigen\Announce\Api\Data\StatsExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Xigen\Announce\Api\Data\StatsExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get impressions
     * @return string|null
     */
    public function getImpressions()
    {
        return $this->_get(self::IMPRESSIONS);
    }

    /**
     * Set impressions
     * @param string $impressions
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setImpressions($impressions)
    {
        return $this->setData(self::IMPRESSIONS, $impressions);
    }

    /**
     * Get first_impression_date
     * @return string|null
     */
    public function getFirstImpressionDate()
    {
        return $this->_get(self::FIRST_IMPRESSION_DATE);
    }

    /**
     * Set first_impression_date
     * @param string $firstImpressionDate
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setFirstImpressionDate($firstImpressionDate)
    {
        return $this->setData(self::FIRST_IMPRESSION_DATE, $firstImpressionDate);
    }

    /**
     * Get last_impression_date
     * @return string|null
     */
    public function getLastImpressionDate()
    {
        return $this->_get(self::LAST_IMPRESSION_DATE);
    }

    /**
     * Set last_impression_date
     * @param string $lastImpressionDate
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setLastImpressionDate($lastImpressionDate)
    {
        return $this->setData(self::LAST_IMPRESSION_DATE, $lastImpressionDate);
    }

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
     * @return \Xigen\Announce\Api\Data\StatsInterface
     */
    public function setMessageId($messageId)
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
    }
}
