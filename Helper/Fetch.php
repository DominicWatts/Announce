<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Api\Data\MessageInterface;
use Xigen\Announce\Api\GroupRepositoryInterface;
use Xigen\Announce\Api\MessageRepositoryInterface;
use Xigen\Announce\Model\ResourceModel\Group\CollectionFactory as GroupCollectionFactory;
use Xigen\Announce\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;

class Fetch extends AbstractHelper
{
    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepositoryInterface;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepositoryInterface;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderFactory
     */
    private $sortOrderFactory;

    /**
     * @var GroupCollectionFactory
     */
    private $groupCollectionFactory;

    /**
     * @var Customer
     */
    private $customerHelper;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MessageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * Fetch constructor.
     * @param Context $context
     * @param GroupRepositoryInterface $groupRepositoryInterface
     * @param MessageRepositoryInterface $messageRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderFactory $sortOrderFactory
     * @param GroupCollectionFactory $groupCollectionFactory
     * @param Customer $customerHelper
     * @param Registry $registry
     * @param LoggerInterface $logger
     * @param MessageCollectionFactory $messageCollectionFactory
     */
    public function __construct(
        Context $context,
        GroupRepositoryInterface $groupRepositoryInterface,
        MessageRepositoryInterface $messageRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderFactory $sortOrderFactory,
        GroupCollectionFactory $groupCollectionFactory,
        Customer $customerHelper,
        Registry $registry,
        LoggerInterface $logger,
        MessageCollectionFactory $messageCollectionFactory
    ) {
        $this->groupRepositoryInterface = $groupRepositoryInterface;
        $this->messageRepositoryInterface = $messageRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderFactory = $sortOrderFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->customerHelper = $customerHelper;
        $this->registry = $registry;
        $this->logger = $logger;
        $this->messageCollectionFactory = $messageCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Get messages by Group
     * @param GroupInterface|int $group
     * @return MessageInterface[]|null
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMessageByGroup($group)
    {
        if ($group) {
            if (is_int($group)) {
                $groupId = $group;
            } elseif ($group instanceof GroupInterface) {
                $groupId = $group->getGroupId();
            } else {
                return [];
            }

            $this->searchCriteriaBuilder->addFilter(MessageInterface::STATUS, [Data::ENABLED], 'eq');
            $this->searchCriteriaBuilder->addFilter(MessageInterface::GROUP_ID, [$groupId], 'eq');

            if ($group->getSortby() == Data::ORDERLY) {
                $sortBySort = $this->createSortOrder(MessageInterface::SORT);
                $sortByName = $this->createSortOrder(MessageInterface::NAME);
                $this->searchCriteriaBuilder->setSortOrders([$sortBySort, $sortByName]);
                if ($limit = $group->getLimit()) {
                    $this->searchCriteriaBuilder->setCurrentPage(Data::FIRST_PAGE);
                    $this->searchCriteriaBuilder->setPageSize((int) $limit);
                }
            }

            $searchCriteria = $this->searchCriteriaBuilder->create();
            $result = $this->messageRepositoryInterface->getList($searchCriteria)->getItems();
            if ($group->getSortby() == Data::RANDOM) {
                shuffle($result);
                if ($limit = $group->getLimit()) {
                    return array_slice($result, 0, (int) $limit);
                }
                return $result;
            }
            return $result;
        }
        return [];
    }

    /**
     * Get groups - sort by name
     * @param bool $enabledOnly
     * @return GroupInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGroups($enabledOnly = true)
    {
        if ($enabledOnly) {
            $this->searchCriteriaBuilder->addFilter(GroupInterface::STATUS, [Data::ENABLED], 'eq');
        }
        $sortOrder = $this->createSortOrder(GroupInterface::NAME);
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->groupRepositoryInterface->getList($searchCriteria)->getItems();
    }

    /**
     * Get messages - sort by name
     * @param bool $enabledOnly
     * @param int|GroupInterface $group
     * @return MessageInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMessages($enabledOnly = true, $group = false)
    {
        if ($enabledOnly) {
            $this->searchCriteriaBuilder->addFilter(MessageInterface::STATUS, [Data::ENABLED], 'eq');
        }

        $groupId = null;
        if (is_int($group)) {
            $groupId = $group;
        } elseif ($group instanceof GroupInterface) {
            $groupId = $group->getGroupId();
        }

        if ($groupId) {
            $this->searchCriteriaBuilder->addFilter(MessageInterface::GROUP_ID, [$groupId], 'eq');
        }
        $sortOrder = $this->createSortOrder(MessageInterface::NAME);
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->messageRepositoryInterface->getList($searchCriteria)->getItems();
    }

    /**
     * Get groups by group ID
     * @param array|int $groupId
     * @return GroupInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGroupsById($groupId = null)
    {
        if (!empty($groupId)) {
            if (is_int($groupId)) {
                $this->searchCriteriaBuilder->addFilter(GroupInterface::GROUP_ID, $groupId, 'eq');
            } elseif (is_array($groupId)) {
                $this->searchCriteriaBuilder->addFilter(GroupInterface::GROUP_ID, $groupId, 'in');
            }
            $sortBySort = $this->createSortOrder(GroupInterface::SORT);
            $sortByName = $this->createSortOrder(GroupInterface::NAME);
            $this->searchCriteriaBuilder->setSortOrders([$sortBySort, $sortByName]);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            return $this->groupRepositoryInterface->getList($searchCriteria)->getItems();
        }
        return [];
    }

    /**
     * Get applicable group IDs
     * @return array|null
     */
    public function getFilteredGroupIds()
    {
        if ($groupId = $this->registry->registry(Data::REGISTRY_KEY)) {
            return $groupId;
        }

        $collection = $this->groupCollectionFactory
            ->create()
            ->addStatusFilter(Data::ENABLED)
            ->addStoreFilter()
            ->addDateFilter();

        if ($this->customerHelper->isLoggedIn()) {
            if ($customerGroupId = $this->customerHelper->getGroupId()) {
                $collection->addCustomerGroupFilter($customerGroupId);
            }
            if ($email = $this->customerHelper->getEmail()) {
                $collection->addCustomerEmailFilter($email);
            }
        }

        $currentCategory = $this->registry->registry('current_category');
        if ($currentCategory && $currentCategory->getId()) {
            $collection->addCategoryFilter($currentCategory->getId());
        } else {
            $collection->addFieldToFilter(GroupInterface::CATEGORY, ['null' => true]);
        }

        $collection->setOrder(GroupInterface::SORT, SortOrder::SORT_ASC);

        if ($collection->getSize() > 0) {
            $groupId = $collection->getAllIds();
        } else {
            // can't think of a better way of doing this for now
            $groupId[] = 99999999999;
        }

        $this->registry->register(Data::REGISTRY_KEY, $groupId);
        return $groupId;
    }

    /**
     * Get group ID by position
     * @param array $positionCode
     * @return array
     */
    public function getGroupIdByPosition($positionCode = [])
    {
        if (!empty($positionCode)) {
            $groupId = $this->getFilteredGroupIds();
            $collection = $this->groupCollectionFactory
                ->create()
                ->addFieldToFilter(GroupInterface::GROUP_ID, ['in' => $groupId])
                ->addFieldToFilter(GroupInterface::POSITION, ['in' => $positionCode])
                ->setOrder(GroupInterface::SORT, SortOrder::SORT_ASC);
            if ($collection->getSize() > 0) {
                return $collection->getAllIds();
            }
        }
        return [];
    }

    /**
     * Get message ID by group ID
     * @param array $positionCode
     * @return array
     */
    public function getMessageIdByGroupId($groupId = null)
    {
        if ($groupId) {
            $collection = $this->messageCollectionFactory
                ->create()
                ->addFieldToFilter(MessageInterface::GROUP_ID, ['eq' => $groupId])
                ->setOrder(MessageInterface::MESSAGE_ID, SortOrder::SORT_ASC);
            if ($collection->getSize() > 0) {
                return $collection->getAllIds();
            }
        }
        return [];
    }

    /**
     * Build message comparison string by group ID
     * @param int $groupId
     * @return string
     */
    public function getSavedMessageIdByGroupId($groupId = null)
    {
        $array = $this->getMessageIdByGroupId($groupId);
        return (string) implode('&', $array);
    }

    /**
     * Get group by ID
     * @param int $groupId
     * @return bool|GroupInterface
     */
    public function getGroupById($groupId = null)
    {
        if ($groupId) {
            try {
                return $this->groupRepositoryInterface->get($groupId);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
        return false;
    }

    /**
     * Get groups for blocks factoring session data
     * @param array $positionCode
     * @return GroupInterface[]|null
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGroupsForBlock($positionCode = [])
    {
        if (!empty($positionCode)) {
            $groupId = $this->getGroupIdByPosition($positionCode);
            return $this->getGroupsById($groupId);
        }
        return null;
    }

    /**
     * Get messages by message ID
     * @param array $messageId
     * @return MessageInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMessagesById($messageId = [])
    {
        if (count($messageId)) {
            $this->searchCriteriaBuilder->addFilter(MessageInterface::MESSAGE_ID, $messageId, 'in');
            $sortBySort = $this->createSortOrder(MessageInterface::SORT);
            $sortByName = $this->createSortOrder(MessageInterface::NAME);
            $this->searchCriteriaBuilder->setSortOrders([$sortBySort, $sortByName]);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            return $this->messageRepositoryInterface->getList($searchCriteria)->getItems();
        }
        return [];
    }

    /**
     * Create order order
     * @param string $attributeCode
     * @param string $direction
     * @return SortOrder
     * @throws \Magento\Framework\Exception\InputException
     */
    protected function createSortOrder($attributeCode, $direction = SortOrder::SORT_ASC)
    {
        return $this->sortOrderFactory
            ->create()
            ->setField($attributeCode)
            ->setDirection($direction);
    }
}
