<?php

namespace Xigen\Announce\Model\Config\Source;

use Xigen\Announce\Api\GroupRepositoryInterface;
use Xigen\Announce\Api\Data\GroupInterfaceFactory;
use Xigen\Announce\Api\Data\GroupInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderFactory;
use Magento\Framework\Api\SortOrder;

class Group implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepositoryInterface;

    /**
     * @var GroupInterfaceFactory
     */
    protected $groupInterfaceFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SortOrderFactory
     */
    private $sortOrderFactory;

    /**
     * @param ProductRepositoryInterface $productRepositoryInterface
     */
    public function __construct(
        GroupRepositoryInterface $groupRepositoryInterface,
        GroupInterfaceFactory $groupInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderFactory $sortOrderFactory
    ) {
        $this->groupRepositoryInterface = $groupRepositoryInterface;
        $this->groupInterfaceFactory = $groupInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderFactory = $sortOrderFactory;
    }

    /**
     * Get enabled groups - sort by name
     * @return array
     */
    private function getGroups()
    {
        $this->searchCriteriaBuilder->addFilter(GroupInterface::STATUS, [1], 'eq');
        $sortOrder = $this->sortOrderFactory
            ->create()
            ->setField(GroupInterface::NAME)
            ->setDirection(SortOrder::SORT_ASC);
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->groupRepositoryInterface->getList($searchCriteria)->getItems();
    }

    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        
        $return = [
            [
                'value' => '',
                'label' => __('Please select')
            ]
        ];

        $items = $this->getGroups();
        foreach ($items as $item) {
            $return[] = [
                'value' => $item->getGroupId(),
                'label' => __(
                    '[%1] %2',
                    $item->getGroupId(),
                    $item->getName()
                )
            ];
        }
        return $return;
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        $items = $this->getGroups();
        $return = [];
        foreach ($items as $item) {
            $return[$item->getGroupId()] = $item->getName();
        }
        return $return;
    }
}
