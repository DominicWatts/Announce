<?php

declare(strict_types=1);

namespace Xigen\Announce\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Api\Data\GroupInterfaceFactory;
use Xigen\Announce\Helper\Fetch;
use Xigen\Announce\Model\ResourceModel\Group\Collection;
use Xigen\Announce\Model\ResourceModel\Message\CollectionFactory;

class Group extends AbstractModel
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
     * @var Fetch
     */
    private $fetchHelper;

    /**
     * @var CollectionFactory
     */
    protected $messageCollectionFactory;

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
        Context $context,
        Registry $registry,
        GroupInterfaceFactory $groupDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Xigen\Announce\Model\ResourceModel\Group $resource,
        Collection $resourceCollection,
        CollectionFactory $messageCollectionFactory,
        DateTime $dateTime,
        Fetch $fetchHelper,
        array $data = []
    ) {
        $this->groupDataFactory = $groupDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dateTime = $dateTime;
        $this->fetchHelper = $fetchHelper;
        $this->messageCollectionFactory = $messageCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Before save
     */
    public function beforeSave()
    {
        if (is_array($this->getData(GroupInterface::STORE_ID))) {
            $this->setStoreId(implode(',', $this->getData(GroupInterface::STORE_ID)));
        }
        if (is_array($this->getData(GroupInterface::CUSTOMER_GROUP_ID))) {
            $this->setCustomerGroupId(implode(',', $this->getData(GroupInterface::CUSTOMER_GROUP_ID)));
        }
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

    /**
     * Get messages - sort by name
     * @param bool $enabledOnly
     * @param int $groupId
     * @return MessageInterface[]|null
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMessages()
    {
        return $this->fetchHelper->getMessages(false, $this->getGroupId());
    }

    /**
     * Get messages collection
     * @return CollectionFactory
     */
    public function getMessagesCollection()
    {
        $collection = $this->messageCollectionFactory->create()
            ->filterByGroupId($this->getGroupId());
        if ($this->getId()) {
            foreach ($collection as $message) {
                $message->setGroup($this);
            }
        }
        return $collection;
    }

    /**
     * Get messages by id
     * @param mixed $messageId
     * @return false
     */
    public function getMessageById($messageId)
    {
        foreach ($this->getMessagesCollection() as $message) {
            if ($message->getMessageId() == $messageId) {
                return $message;
            }
        }
        return false;
    }
}
