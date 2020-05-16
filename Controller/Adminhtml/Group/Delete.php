<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Registry;
use Xigen\Announce\Model\GroupFactory;

class Delete extends \Xigen\Announce\Controller\Adminhtml\Group
{
    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var GroupFactory
     */
    protected $groupFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param RedirectFactory $resultRedirectFactory
     * @param GroupFactory $groupFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        RedirectFactory $resultRedirectFactory,
        GroupFactory $groupFactory
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->groupFactory = $groupFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('group_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->groupFactory->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Group.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['group_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Group to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
