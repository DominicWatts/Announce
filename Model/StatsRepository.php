<?php

declare(strict_types=1);

namespace Xigen\Announce\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Xigen\Announce\Api\Data\StatsInterfaceFactory;
use Xigen\Announce\Api\Data\StatsSearchResultsInterfaceFactory;
use Xigen\Announce\Api\StatsRepositoryInterface;
use Xigen\Announce\Model\ResourceModel\Stats as ResourceStats;
use Xigen\Announce\Model\ResourceModel\Stats\CollectionFactory as StatsCollectionFactory;

class StatsRepository implements StatsRepositoryInterface
{
    /**
     * @var StatsFactory
     */
    protected $statsFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var StatsSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var ResourceStats
     */
    protected $resource;

    /**
     * @var StatsInterfaceFactory
     */
    protected $dataStatsFactory;

    /**
     * @var StatsCollectionFactory
     */
    protected $statsCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceStats $resource
     * @param StatsFactory $statsFactory
     * @param StatsInterfaceFactory $dataStatsFactory
     * @param StatsCollectionFactory $statsCollectionFactory
     * @param StatsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceStats $resource,
        StatsFactory $statsFactory,
        StatsInterfaceFactory $dataStatsFactory,
        StatsCollectionFactory $statsCollectionFactory,
        StatsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->statsFactory = $statsFactory;
        $this->statsCollectionFactory = $statsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataStatsFactory = $dataStatsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Xigen\Announce\Api\Data\StatsInterface $stats
    ) {
        $statsData = $this->extensibleDataObjectConverter->toNestedArray(
            $stats,
            [],
            \Xigen\Announce\Api\Data\StatsInterface::class
        );

        $statsModel = $this->statsFactory->create()->setData($statsData);

        try {
            $this->resource->save($statsModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the stats: %1',
                $exception->getMessage()
            ));
        }
        return $statsModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($statsId)
    {
        $stats = $this->statsFactory->create();
        $this->resource->load($stats, $statsId);
        if (!$stats->getId()) {
            throw new NoSuchEntityException(__('Stats with id "%1" does not exist.', $statsId));
        }
        return $stats->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->statsCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Xigen\Announce\Api\Data\StatsInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Xigen\Announce\Api\Data\StatsInterface $stats
    ) {
        try {
            $statsModel = $this->statsFactory->create();
            $this->resource->load($statsModel, $stats->getStatsId());
            $this->resource->delete($statsModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Stats: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($statsId)
    {
        return $this->delete($this->get($statsId));
    }
}
