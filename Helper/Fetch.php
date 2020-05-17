<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Api\Data\GroupInterfaceFactory;
use Xigen\Announce\Api\Data\MessageInterface;
use Xigen\Announce\Api\Data\MessageInterfaceFactory;
use Xigen\Announce\Api\GroupRepositoryInterface;
use Xigen\Announce\Api\MessageRepositoryInterface;
use Xigen\Announce\Model\ResourceModel\Group\CollectionFactory as GroupCollectionFactory;

class Fetch extends AbstractHelper
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
     * @var MessageRepositoryInterface
     */
    protected $messageRepositoryInterface;

    /**
     * @var MessageInterfaceFactory
     */
    protected $messageInterfaceFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

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
     * @var TimezoneInterface
     */
    private $localeDate;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Fetch constructor.
     * @param Context $context
     * @param GroupRepositoryInterface $groupRepositoryInterface
     * @param GroupInterfaceFactory $groupInterfaceFactory
     * @param MessageRepositoryInterface $messageRepositoryInterface
     * @param MessageInterfaceFactory $messageInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderFactory $sortOrderFactory
     * @param GroupCollectionFactory $groupCollectionFactory
     * @param Customer $customerHelper
     * @param Registry $registry
     * @param TimezoneInterface $localeDate
     * @param Logger $logger,
     */
    public function __construct(
        Context $context,
        GroupRepositoryInterface $groupRepositoryInterface,
        GroupInterfaceFactory $groupInterfaceFactory,
        MessageRepositoryInterface $messageRepositoryInterface,
        MessageInterfaceFactory $messageInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderFactory $sortOrderFactory,
        GroupCollectionFactory $groupCollectionFactory,
        Customer $customerHelper,
        Registry $registry,
        TimezoneInterface $localeDate,
        LoggerInterface $logger
    ) {
        $this->groupRepositoryInterface = $groupRepositoryInterface;
        $this->groupInterfaceFactory = $groupInterfaceFactory;
        $this->messageRepositoryInterface = $messageRepositoryInterface;
        $this->messageInterfaceFactory = $messageInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderFactory = $sortOrderFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->customerHelper = $customerHelper;
        $this->registry = $registry;
        $this->localeDate = $localeDate;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @param null $groupId
     * @return MessageInterface[]|null
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMessageByGroup($groupId = null)
    {
        if ($groupId) {
            $this->searchCriteriaBuilder->addFilter(MessageInterface::STATUS, [Data::ENABLED], 'eq');
            $this->searchCriteriaBuilder->addFilter(MessageInterface::GROUP_ID, [$groupId], 'eq');
            $sortBySort = $this->sortOrderFactory
                ->create()
                ->setField(MessageInterface::SORT)
                ->setDirection(SortOrder::SORT_ASC);
            $sortByName = $this->sortOrderFactory
                ->create()
                ->setField(MessageInterface::NAME)
                ->setDirection(SortOrder::SORT_ASC);
            $this->searchCriteriaBuilder->setSortOrders([$sortBySort, $sortByName]);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            return $this->messageRepositoryInterface->getList($searchCriteria)->getItems();
        }
        return null;
    }

    /**
     * Get enabled groups - sort by name
     * @return GroupInterface[]
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getGroups()
    {
        $this->searchCriteriaBuilder->addFilter(GroupInterface::STATUS, [Data::ENABLED], 'eq');
        $sortOrder = $this->sortOrderFactory
            ->create()
            ->setField(GroupInterface::NAME)
            ->setDirection(SortOrder::SORT_ASC);
        $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->groupRepositoryInterface->getList($searchCriteria)->getItems();
    }

    /**
     * Get applicable group IDs
     * @return array|null
     */
    public function getGroupId()
    {
        if ($groupId = $this->registry->registry('announce_group_id')) {
            return $groupId;
        }

        $collection = $this->groupCollectionFactory
            ->create()
            ->addFieldToFilter(GroupInterface::STATUS, ['eq' => Data::ENABLED])
            ->setOrder(GroupInterface::SORT, 'ASC');

        $collection = $this->filterWithinDate($collection);
        $collection = $this->filterForCustomer($collection);
        $collection = $this->getFilterForCustomerGroup($collection);
        $collection = $this->getFilterForStore($collection);

        if ($collection->getSize() > 0) {
            $groupId = $collection->getAllIds();
        } else {
            // can't think of a better way of doing this for now
            $groupId[] = 99999999999;
        }

        $this->registry->register('announce_group_id', $groupId);
    }

    /**
     * Filter collection within dates
     * @param GroupCollectionFactory $collection
     * @return GroupCollectionFactory
     */
    public function filterWithinDate($collection)
    {
        $todayStartOfDayDate = $this->localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $collection->addFieldToFilter(
            GroupInterface::DATE_FROM,
            [
                'or' => [
                    0 => ['date' => true, 'to' => $todayEndOfDayDate],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        )->addFieldToFilter(
            GroupInterface::DATE_TO,
            [
                'or' => [
                    0 => ['date' => true, 'from' => $todayStartOfDayDate],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        )->addFieldToFilter(
            [GroupInterface::DATE_FROM, GroupInterface::DATE_TO],
            [
                ['is' => new \Zend_Db_Expr('not null')],
                ['is' => new \Zend_Db_Expr('not null')]
            ]
        );

        return $collection;
    }

    /**
     * Filter collection for customer
     * @param GroupCollectionFactory $collection
     * @return GroupCollectionFactory
     */
    public function filterForCustomer($collection)
    {
        if (!$this->customerHelper->isLoggedIn()) {
            return $collection;
        }

        $email = $this->customerHelper->getEmail();

        $collection->addFieldToFilter(
            [GroupInterface::EMAIL, GroupInterface::EMAIL],
            [
                ['eq' => $email],
                ['is' => new \Zend_Db_Expr('null')]
            ]
        );

        return $collection;
    }

    /**
     * Filter collection for customer group
     * @param GroupCollectionFactory $collection
     * @return GroupCollectionFactory
     */
    public function getFilterForCustomerGroup($collection)
    {
        if (!$this->customerHelper->isLoggedIn()) {
            return $collection;
        }

        $groupId = $this->customerHelper->getGroupId();

        $collection->addFieldToFilter(
            GroupInterface::CUSTOMER_GROUP_ID,
            [
                'or' => [
                    0 => ['finset' => $groupId],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        );

        return $collection;
    }

    /**
     * Filter collection by store
     * @param GroupCollectionFactory $collection
     * @return GroupCollectionFactory mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getFilterForStore($collection)
    {
        $storeId = $this->customerHelper->getStoreId();
        $collection->addFieldToFilter(
            GroupInterface::STORE_ID,
            [
                'or' => [
                    0 => ['finset' => Data::ALL_STORE_VIEWS],
                    1 => ['finset' => $storeId],
                ]
            ],
            'left'
        );
        return $collection;
    }

    /**
     * Filter collection by position code
     * @param GroupCollectionFactory$collection
     * @param string $positionCode
     * @return GroupCollectionFactory
     */
    public function getFilterForPosition($collection, $positionCode)
    {
        $collection->addFieldToFilter(GroupInterface::POSITION, ['eq' => $positionCode]);
        return $collection;
    }

    /**
     * Get group by ID
     * @param int $groupId
     * @return bool|GroupInterface
     */
    public function getGroup($groupId = null)
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
}
