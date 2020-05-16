<?php

declare(strict_types=1);

namespace Xigen\Announce\Api\Data;

interface GroupSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Group list.
     * @return \Xigen\Announce\Api\Data\GroupInterface[]
     */
    public function getItems();

    /**
     * Set cssclass list.
     * @param \Xigen\Announce\Api\Data\GroupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
