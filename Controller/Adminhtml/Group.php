<?php

declare(strict_types=1);

namespace Xigen\Announce\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

abstract class Group extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Xigen_Announce::top_level';

    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Group constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Xigen'), __('Xigen'))
            ->addBreadcrumb(__('Group'), __('Group'));
        return $resultPage;
    }
}
