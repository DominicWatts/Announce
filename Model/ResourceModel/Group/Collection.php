<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel\Group;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Xigen\Announce\Api\Data\GroupInterface;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'group_id';

    /**
     * @var int
     */
    protected $_storeId;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var TimezoneInterface
     */
    protected $localeDate;

    /**
     * Collection constructor.
     * @param EntityFactory $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     * @param StoreManagerInterface $storeManager
     * @param TimezoneInterface $localeDate
     */
    public function __construct(
        EntityFactory $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null,
        StoreManagerInterface $storeManager,
        TimezoneInterface $localeDate
    ) {
        $this->_storeManager = $storeManager;
        $this->localeDate = $localeDate;
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
    }

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Xigen\Announce\Model\Group::class,
            \Xigen\Announce\Model\ResourceModel\Group::class
        );
    }

    /**
     * Set random groups order
     * @return $this
     */
    public function setRandomOrder()
    {
        $this->getConnection()->orderRand($this->getSelect());
        return $this;
    }

    /**
     * Filter collection by status
     * @param string $status
     * @return $this
     */
    public function addStatusFilter($status = null)
    {
        if (empty($status)) {
            $this->addFieldToFilter(GroupInterface::STATUS, ['null' => true]);
        } else {
            $this->addFieldToFilter(GroupInterface::STATUS, $status);
        }
        return $this;
    }

    /**
     * Filter collection within dates
     * @return $this
     */
    public function addDateFilter()
    {
        $todayStartOfDayDate = $this->localeDate->date()
            ->setTime(0, 0, 0)
            ->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->localeDate->date()
            ->setTime(23, 59, 59)
            ->format('Y-m-d H:i:s');

        $this->addFieldToFilter(
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

        return $this;
    }

    /**
     * Filter collection for customer group ID
     * @param int $groupId
     * @return $this
     */
    public function addCustomerGroupFilter($groupId)
    {
        if (empty($groupId)) {
            return $this;
        }

        $this->addFieldToFilter(
            GroupInterface::CUSTOMER_GROUP_ID,
            [
                'or' => [
                    0 => ['finset' => $groupId],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        );
        return $this;
    }

    /**
     * Filter collection for category ID
     * @param int $categoryId
     * @return $this
     */
    public function addCategoryFilter($categoryId)
    {
        if (empty($categoryId)) {
            return $this;
        }

        $this->addFieldToFilter(
            GroupInterface::CATEGORY,
            [
                'or' => [
                    0 => ['finset' => $categoryId],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        );
        return $this;
    }

    /**
     * Filter collection for product ID
     * @param int $productId
     * @return $this
     */
    public function addProductFilter($productId)
    {
        if (empty($productId)) {
            return $this;
        }

        $this->addFieldToFilter(
            GroupInterface::PRODUCT,
            [
                'or' => [
                    0 => ['finset' => $productId],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ],
            'left'
        );
        return $this;
    }

    /**
     * Filter collection for customer email
     * @param $email
     * @return $this
     */
    public function addCustomerEmailFilter($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this;
        }

        $this->addFieldToFilter(
            [GroupInterface::EMAIL, GroupInterface::EMAIL],
            [
                ['eq' => $email],
                ['is' => new \Zend_Db_Expr('null')]
            ]
        );

        return $this;
    }

    /**
     * Add store availability filter. Include availability product for store website.
     *
     * @param null|string|bool|int|Store $store
     * @return $this
     */
    public function addStoreFilter($store = null)
    {
        if ($store === null) {
            $store = $this->getStoreId();
        }

        try {
            $store = $this->_storeManager->getStore($store);
        } catch (NoSuchEntityException $e) {
            return $this;
        }

        if ($store->getId()) {
            $this->addFieldToFilter(
                GroupInterface::STORE_ID,
                [
                    'or' => [
                        0 => ['finset' => Store::DEFAULT_STORE_ID],
                        1 => ['finset' => $store->getId()],
                    ]
                ],
                'left'
            );
            return $this;
        }
        return $this;
    }

    /**
     * Return current store id
     * @return int
     */
    public function getStoreId()
    {
        if ($this->_storeId === null) {
            $this->setStoreId($this->_storeManager->getStore()->getId());
        }
        return $this->_storeId;
    }

    /**
     * Set store scope ID
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
        return $this;
    }
}
