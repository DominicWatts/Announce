<?php

declare(strict_types=1);

namespace Xigen\Announce\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Api\Data\GroupInterfaceFactory;

class Group extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'xigen_announce_group';

    /**
     * @var GroupInterfaceFactory
     */
    protected $groupDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param GroupInterfaceFactory $groupDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Xigen\Announce\Model\ResourceModel\Group $resource
     * @param \Xigen\Announce\Model\ResourceModel\Group\Collection $resourceCollection
     * @param DateTime $dateTime
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        GroupInterfaceFactory $groupDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Xigen\Announce\Model\ResourceModel\Group $resource,
        \Xigen\Announce\Model\ResourceModel\Group\Collection $resourceCollection,
        DateTime $dateTime,
        array $data = []
    ) {
        $this->groupDataFactory = $groupDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dateTime = $dateTime;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Before save
     */
    public function beforeSave()
    {
        $this->setStoreId(implode($this->getData(GroupInterface::STORE_ID), ','));
        $this->setCustomerGroupId(implode($this->getData(GroupInterface::CUSTOMER_GROUP_ID), ','));
        $this->setUpdatedAt($this->dateTime->gmtDate());
        if ($this->isObjectNew()) {
            $this->setCreatedAt($this->dateTime->gmtDate());
        }
        return parent::beforeSave();
    }

    /**
     * Retrieve group model with group data
     * @return GroupInterface
     */
    public function getDataModel()
    {
        $groupData = $this->getData();

        $groupDataObject = $this->groupDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $groupDataObject,
            $groupData,
            GroupInterface::class
        );

        return $groupDataObject;
    }
}
