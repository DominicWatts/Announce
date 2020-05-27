<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml\Group;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite as RewriteAction;
use Xigen\Announce\Block\Adminhtml\Group\Edit\Tab\Message;

class MessageGrid extends RewriteAction implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * Ajax messages grid action
     *
     * @return void
     */
    public function execute()
    {
        $this->getResponse()->setBody(
            $this->_view->getLayout()->createBlock(Message::class)->toHtml()
        );
    }
}
