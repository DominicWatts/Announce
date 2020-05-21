<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Model\GroupFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var GroupFactory
     */
    protected $groupFactory;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        GroupFactory $groupFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->groupFactory = $groupFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue(Data::GROUP_TAB);
        if ($data) {
            $id = $this->getRequest()->getParam('group_id');

            $model = $this->groupFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Group no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Group.'));
                $this->dataPersistor->clear('xigen_announce_group');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['group_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Group.'));
            }

            $this->dataPersistor->set('xigen_announce_group', $data);
            return $resultRedirect->setPath('*/*/edit', ['group_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
