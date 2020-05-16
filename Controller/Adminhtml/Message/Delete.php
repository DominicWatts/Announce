<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Message;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Registry;
use Xigen\Announce\Model\MessageFactory;

class Delete extends \Xigen\Announce\Controller\Adminhtml\Message
{
    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param RedirectFactory $resultRedirectFactory
     * @param MessageFactory $messageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        RedirectFactory $resultRedirectFactory,
        MessageFactory $messageFactory
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->$messageFactory = $messageFactory;
        parent::__construct($context, $coreRegistry);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('message_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->messageFactory->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Message.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['message_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Message to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
