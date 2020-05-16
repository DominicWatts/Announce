<?php

declare(strict_types=1);

namespace Xigen\Announce\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Xigen\Announce\Api\Data\MessageInterface;
use Xigen\Announce\Api\Data\MessageInterfaceFactory;

class Message extends \Magento\Framework\Model\AbstractModel
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
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        MessageInterfaceFactory $messageDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Xigen\Announce\Model\ResourceModel\Message $resource,
        \Xigen\Announce\Model\ResourceModel\Message\Collection $resourceCollection,
        DateTime $dateTime,
        array $data = []
    ) {
        $this->messageDataFactory = $messageDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dateTime = $dateTime;
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
}
