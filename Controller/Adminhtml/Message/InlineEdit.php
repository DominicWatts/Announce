<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Message;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Xigen\Announce\Model\MessageFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param MessageFactory $messageFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        MessageFactory $messageFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->messageFactory = $messageFactory;
        parent::__construct($context);
    }

    /**
     * Inline edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $modelId) {
                    /** @var \Xigen\Announce\Model\Message $model */
                    $model = $this->messageFactory->create()->load($modelId);
                    try {
                        $model->setData($postItems[$modelId] + $model->getData());
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Message ID: {$modelId}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
