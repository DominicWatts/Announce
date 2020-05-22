<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Xigen\Announce\Api\Data\GroupInterface;
use Xigen\Announce\Model\ResourceModel\Group\CollectionFactory;

/**
 * Mass-Status Controller.
 */
class MassStatus extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Xigen_Announce::top_level';

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * MassStatus constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action.
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $ids = $this->getRequest()->getPost('selected');
        $status = $this->getRequest()->getParam('status');
        if ($ids) {
            $collection = $this->collectionFactory->create()
                ->addFieldToFilter(GroupInterface::GROUP_ID, ['in' => $ids]);
            $collectionSize = $collection->getSize();
            $updatedItems = 0;
            foreach ($collection as $item) {
                try {
                    $item->setStatus($status);
                    $item->save();
                    $updatedItems++;
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
            if ($updatedItems != 0) {
                if ($collectionSize != $updatedItems) {
                    $this->messageManager->addErrorMessage(
                        __('Failed to update %1 group item(s).', $collectionSize - $updatedItems)
                    );
                }
                $this->messageManager->addSuccessMessage(
                    __('A total of %1 group item(s) have been updated.', $updatedItems)
                );
            }
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
