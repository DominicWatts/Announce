<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Xigen\Announce\Model\GroupFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var GroupFactory
     */
    protected $groupFactory;

    /**
     * InlineEdit constructor.
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param GroupFactory $groupFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        GroupFactory $groupFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->groupFactory = $groupFactory;
        parent::__construct($context);
    }

    /**
     * Inline edit action
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
                    /** @var \Xigen\Announce\Model\Group $model */
                    $model = $this->groupFactory->create()->load($modelId);
                    try {
                        $model->setData($postItems[$modelId] + $model->getData());
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = "[Group ID: {$modelId}]  {$e->getMessage()}";
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
