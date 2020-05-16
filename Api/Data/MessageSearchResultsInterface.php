<?php

declare(strict_types=1);

namespace Xigen\Announce\Api\Data;

interface MessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Message list.
     * @return \Xigen\Announce\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Xigen\Announce\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
