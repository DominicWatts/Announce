<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Helper\Fetch;
use Xigen\Announce\Helper\Update;
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
        GroupFactory $groupFactory,
        Fetch $fetchHelper,
        Update $updateHelper
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->groupFactory = $groupFactory;
        $this->fetchHelper = $fetchHelper;
        $this->updateHelper = $updateHelper;
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

                // now process the associated messages tab
                $message = $this->getRequest()->getPostValue(Data::MESSAGE_TAB);
                if ($data) {
                    $submittedMessageString = (string) $message['list'] ?: null;
                    $savedMessageString = $this->fetchHelper->getSavedMessageIdByGroupId($model->getId());

                    if ($submittedMessageString != $savedMessageString) {
                        $messagesByGroup = $this->fetchHelper->getMessages(false, $model->getId());
                        $this->updateHelper->setMessagesAsNull($messagesByGroup);
                        if ($submittedMessageString) {
                            $submittedmessageId = explode('&', $submittedMessageString);
                            $messages = $this->fetchHelper->getMessagesById($submittedmessageId);
                            $this->updateHelper->setMessagesAsGroupId($messages, $model->getId());
                        }
                    }
                }

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
