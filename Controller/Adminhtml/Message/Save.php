<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Message;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Xigen\Announce\Model\MessageFactory;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        MessageFactory $messageFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->messageFactory = $messageFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('message_id');

            $model = $this->messageFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Message no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Message.'));
                $this->dataPersistor->clear('xigen_announce_message');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['message_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Message.'));
            }

            $this->dataPersistor->set('xigen_announce_message', $data);
            return $resultRedirect->setPath('*/*/edit', ['message_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
