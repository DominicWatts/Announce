<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Xigen\Announce\Model\GroupFactory;

class Edit extends \Xigen\Announce\Controller\Adminhtml\Group
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var GroupFactory
     */
    protected $groupFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Edit constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param GroupFactory $groupFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        GroupFactory $groupFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->groupFactory = $groupFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('group_id');
        $model = $this->groupFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Group no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('xigen_announce_group', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Group') : __('New Group'),
            $id ? __('Edit Group') : __('New Group')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Groups'));
        $resultPage->getConfig()->getTitle()->prepend(
            $id ? __('Edit Group [%1] %2', $id, $model->getName()) : __('New Group')
        );
        return $resultPage;
    }
}
