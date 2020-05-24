<?php

declare(strict_types=1);

namespace Xigen\Announce\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Xigen\Announce\Api\Data\MessageInterface;
use Xigen\Announce\Api\Data\MessageInterfaceFactory;
use Xigen\Announce\Model\ResourceModel\Message\Collection;

class Message extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'xigen_announce_message';

    /**
     * @var MessageInterfaceFactory
     */
    protected $messageDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var \Xigen\Announce\Model\Group
     */
    protected $group;

    /**
     * @var \Xigen\Announce\Model\GroupFactory
     */
    protected $groupFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param MessageInterfaceFactory $messageDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Xigen\Announce\Model\ResourceModel\Message $resource
     * @param \Xigen\Announce\Model\ResourceModel\Message\Collection $resourceCollection
     * @param DateTime $dateTime
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        MessageInterfaceFactory $messageDataFactory,
        DataObjectHelper $dataObjectHelper,
        GroupFactory $groupFactory,
        \Xigen\Announce\Model\ResourceModel\Message $resource,
        Collection $resourceCollection,
        DateTime $dateTime,
        array $data = []
    ) {
        $this->messageDataFactory = $messageDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dateTime = $dateTime;
        $this->groupFactory = $groupFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Before save
     */
    public function beforeSave()
    {
        $this->setUpdatedAt($this->dateTime->gmtDate());
        if ($this->isObjectNew()) {
            $this->setCreatedAt($this->dateTime->gmtDate());
        }
        return parent::beforeSave();
    }

    /**
     * Retrieve message model with message data
     * @return MessageInterface
     */
    public function getDataModel()
    {
        $messageData = $this->getData();

        $messageDataObject = $this->messageDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $messageDataObject,
            $messageData,
            MessageInterface::class
        );

        return $messageDataObject;
    }

    /**
     * Set group
     * @param \Xigen\Announce\Model\Group $group
     * @return $this
     */
    public function setGroup(\Xigen\Announce\Model\Group $group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Get group
     * @return \Xigen\Announce\Model\Group
     */
    public function getGroup()
    {
        if (!$this->group) {
            $this->group = $this->groupFactory
                ->create()
                ->load($this->getGroupId());
        }
        return $this->group;
    }
}
