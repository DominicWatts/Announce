<?php

declare(strict_types=1);

namespace Xigen\Announce\Block\Adminhtml\Group\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended as ExtendedGrid;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Xigen\Announce\Model\ResourceModel\Message\CollectionFactory;
use Xigen\Announce\Api\Data\GroupInterface;

class Message extends ExtendedGrid implements TabInterface
{
    /**
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @var bool
     */
    protected $isAjaxLoaded = true;

    /**
     * @var \Xigen\Announce\Model\ResourceModel\Message\CollectionFactory
     */
    protected $messageCollectionFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $messageCollectionFactory,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('announce_group_edit_tab_message_grid');
        $this->setDefaultSort('message_id');
        $this->setDefaultDir('DESC');
        $this->setTitle(__('Messages'));
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($groupId = $this->getRequest()->getParam('group_id')) {
            $this->setDefaultFilter(['group_id' => $groupId]);
        }
        if ($this->canShowTab()) {
            $this->setDefaultFilter(['in_messages' => 1]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Messages');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Messages');
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->messageCollectionFactory->create()
            ->addFieldToSelect("*");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_messages',
            [
                'type' => 'checkbox',
                'name' => 'in_messages',
                'values' => $this->_getSelectedMessages(),
                'align' => 'center',
                'index' => 'message_id',
                'header_css_class' => 'col-select',
                'column_css_class' => 'col-select'
            ]
        );

        $this->addColumn(
            'message_id',
            [
                'header' => __('Message Id'),
                'sortable' => true,
                'index' => 'message_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('name'),
                'sortable' => true,
                'index' => 'name',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'align' => 'center',
                'filter' => \Xigen\Announce\Block\Adminhtml\Group\Edit\Tab\Grid\Filter\Status::class,
                'index' => 'status',
                'renderer' => \Xigen\Announce\Block\Adminhtml\Group\Edit\Tab\Grid\Renderer\Status::class
            ]
        );

        $this->addColumn(
            'sort',
            [
                'header' => __('Sort'),
                'type' => 'number',
                'validate_class' => 'validate-number',
                'index' => 'sort',
                'editable' => true,
                'edit_only' => true,
                'header_css_class' => 'col-sort',
                'column_css_class' => 'col-sort'
            ]
        );

        // $this->addExportType('*/*/exportCsv', __('CSV'));
        // $this->addExportType('*/*/exportExcel', __('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * Add filter
     *
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in message flag
        if ($column->getId() == 'in_messages') {
            $messageIds = $this->_getSelectedMessages();
            if (empty($messageIds)) {
                $messageIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('message_id', ['in' => $messageIds]);
            } else {
                if ($messageIds) {
                    $this->getCollection()->addFieldToFilter('message_id', ['nin' => $messageIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function canShowTab()
    {
        return $this->coreRegistry->registry('xigen_announce_group');
    }

    /**
     * Tab should be loaded through Ajax call
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return false;
    }

    /**
     * Checks when this block is readonly
     * @return bool
     */
    public function isReadonly()
    {
        return false;
    }

    /**
     * Retrieve selected related messages
     * @return array
     */
    protected function _getSelectedMessages()
    {
        return array_keys($this->getSelectedMessages());
    }

    /**
     * Retrieve related message
     * @return array
     */
    public function getSelectedMessages()
    {
        $messages = [];
        
        if ($selected = $this->coreRegistry->registry('xigen_announce_group')) {
            $collection = $selected->getMessages();
        } elseif ($groupId = $this->getRequest()->getParam('group_id')) {
            $collection = $this->messageCollectionFactory->create()
                ->addFieldToSelect("*")
                ->addFieldToFilter(GroupInterface::GROUP_ID, ['eq' => $groupId]);
        }

        foreach ($collection as $item) {
            $messages[$item->getMessageId()] = ['sort' => $item->getSort()];
        }

        return $messages;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/message/edit',
            ['message_id' => $row->getId()]
        );
    }
}
