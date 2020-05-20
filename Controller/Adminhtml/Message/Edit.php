<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Message;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Xigen\Announce\Model\MessageFactory;

class Edit extends \Xigen\Announce\Controller\Adminhtml\Message
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Edit constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param MessageFactory $messageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        MessageFactory $messageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->messageFactory = $messageFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('message_id');
        $model = $this->messageFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Message no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('xigen_announce_message', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Message') : __('New Message'),
            $id ? __('Edit Message') : __('New Message')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Messages'));
        $resultPage->getConfig()->getTitle()->prepend(
            $id ? __('Edit Message [%1] %2', $id, $model->getName()) : __('New Message')
        );
        return $resultPage;
    }
}
