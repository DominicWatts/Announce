<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Psr\Log\LoggerInterface;
use Xigen\Announce\Api\Data\StatsInterface;
use Xigen\Announce\Api\Data\StatsInterfaceFactory;
use Xigen\Announce\Api\StatsRepositoryInterface;
use Xigen\Announce\Model\ResourceModel\Stats\CollectionFactory;

class Stats extends AbstractHelper
{
    const ONE = 1;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var StatsInterfaceFactory
     */
    protected $statsInterfaceFactory;

    /**
     * @var StatsRepositoryInterface
     */
    protected $statsRepositoryInterface;

    /**
     * Stats constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     * @param StatsInterfaceFactory $statsInterfaceFactory
     * @param StatsRepositoryInterface $statsRepositoryInterface
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        StatsInterfaceFactory $statsInterfaceFactory,
        StatsRepositoryInterface $statsRepositoryInterface
    ) {
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
        $this->statsInterfaceFactory = $statsInterfaceFactory;
        $this->statsRepositoryInterface = $statsRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * Store impression
     * @param $groupId
     * @param $messageId
     * @return bool
     */
    public function setImpression($groupId, $messageId)
    {
        $stat = $this->getStat($groupId, $messageId);
        if ($stat) {
            try {
                $stat->setImpressions((int) $stat->getImpressions() + self::ONE);
                $stat->save();
                return true;
            } catch (\Exception $e) {
                $this->logger->critical($e);
                return false;
            }
        }

        $stat = $this->statsInterfaceFactory
            ->create()
            ->setImpressions(self::ONE)
            ->setGroupId($groupId)
            ->setMessageId($messageId);
        try {
            $this->statsRepositoryInterface->save($stat);
            return true;
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return false;
        }
    }

    /**
     * Get stats by message ID and group ID
     * @param null $messageId
     * @param null $groupId
     * @return \Magento\Framework\DataObject|null
     */
    public function getStat($messageId = null, $groupId = null)
    {
        if (!$messageId || !$groupId) {
            return null;
        }
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter(StatsInterface::GROUP_ID, ['eq' => $messageId])
            ->addFieldToFilter(StatsInterface::MESSAGE_ID, ['eq' => $groupId]);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return null;
    }

    /**
     * Get stats by group ID
     * @param int $groupId
     * @return mixed
     */
    public function getStatsByGroupId($groupId = null)
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter(StatsInterface::GROUP_ID, ['eq' => $groupId]);
    }

    /**
     * Get stats by message ID
     * @param int $messageId
     * @return mixed
     */
    public function getStatsByMessageId($messageId = null)
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter(StatsInterface::MESSAGE_ID, ['eq' => $messageId]);
    }
}
