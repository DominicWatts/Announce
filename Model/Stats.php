<?php

declare(strict_types=1);

namespace Xigen\Announce\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Xigen\Announce\Api\Data\StatsInterface;
use Xigen\Announce\Api\Data\StatsInterfaceFactory;
use Xigen\Announce\Model\ResourceModel\Stats\Collection;

class Stats extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'xigen_announce_stats';

    /**
     * @var StatsInterfaceFactory
     */
    protected $statsDataFactory;

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
     * @param StatsInterfaceFactory $statsDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Xigen\Announce\Model\ResourceModel\Stats $resource
     * @param \Xigen\Announce\Model\ResourceModel\Stats\Collection $resourceCollection
     * @param DateTime $dateTime
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StatsInterfaceFactory $statsDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Xigen\Announce\Model\ResourceModel\Stats $resource,
        Collection $resourceCollection,
        DateTime $dateTime,
        array $data = []
    ) {
        $this->statsDataFactory = $statsDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dateTime = $dateTime;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Before save
     */
    public function beforeSave()
    {
        $this->setLastImpressionDate($this->dateTime->gmtDate());
        if ($this->isObjectNew()) {
            $this->setFirstImpressionDate($this->dateTime->gmtDate());
        }
        return parent::beforeSave();
    }

    /**
     * Retrieve stats model with stats data
     * @return StatsInterface
     */
    public function getDataModel()
    {
        $statsData = $this->getData();

        $statsDataObject = $this->statsDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $statsDataObject,
            $statsData,
            StatsInterface::class
        );

        return $statsDataObject;
    }
}
