<?php

declare(strict_types=1);

namespace Xigen\Announce\Api\Data;

interface StatsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Stats list.
     * @return \Xigen\Announce\Api\Data\StatsInterface[]
     */
    public function getItems();

    /**
     * Set group_id list.
     * @param \Xigen\Announce\Api\Data\StatsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
