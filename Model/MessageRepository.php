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
use Xigen\Announce\Api\Data\MessageInterfaceFactory;
use Xigen\Announce\Api\Data\MessageSearchResultsInterfaceFactory;
use Xigen\Announce\Api\MessageRepositoryInterface;
use Xigen\Announce\Model\ResourceModel\Message as ResourceMessage;
use Xigen\Announce\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var MessageInterfaceFactory
     */
    protected $dataMessageFactory;

    /**
     * @var MessageSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var MessageCollectionFactory
     */
    protected $messageCollectionFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var ResourceMessage
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceMessage $resource
     * @param MessageFactory $messageFactory
     * @param MessageInterfaceFactory $dataMessageFactory
     * @param MessageCollectionFactory $messageCollectionFactory
     * @param MessageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceMessage $resource,
        MessageFactory $messageFactory,
        MessageInterfaceFactory $dataMessageFactory,
        MessageCollectionFactory $messageCollectionFactory,
        MessageSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->messageFactory = $messageFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataMessageFactory = $dataMessageFactory;
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
        \Xigen\Announce\Api\Data\MessageInterface $message
    ) {
        $messageData = $this->extensibleDataObjectConverter->toNestedArray(
            $message,
            [],
            \Xigen\Announce\Api\Data\MessageInterface::class
        );

        $messageModel = $this->messageFactory->create()->setData($messageData);

        try {
            $this->resource->save($messageModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the message: %1',
                $exception->getMessage()
            ));
        }
        return $messageModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($messageId)
    {
        $message = $this->messageFactory->create();
        $this->resource->load($message, $messageId);
        if (!$message->getId()) {
            throw new NoSuchEntityException(__('Message with id "%1" does not exist.', $messageId));
        }
        return $message->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->messageCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Xigen\Announce\Api\Data\MessageInterface::class
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
        \Xigen\Announce\Api\Data\MessageInterface $message
    ) {
        try {
            $messageModel = $this->messageFactory->create();
            $this->resource->load($messageModel, $message->getMessageId());
            $this->resource->delete($messageModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Message: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($messageId)
    {
        return $this->delete($this->get($messageId));
    }
}
