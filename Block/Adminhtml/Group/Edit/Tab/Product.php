<?php

declare(strict_types=1);

namespace Xigen\Announce\Block\Adminhtml\Group\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Catalog\Model\Product as ModelProduct;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Backend\Helper\Data;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory as SetCollectionFactory;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Registry;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Directory\Model\Currency;
use Magento\Store\Model\ScopeInterface;
use Xigen\Announce\Model\GroupFactory;

class Product extends Extended implements TabInterface
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
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory]
     */
    protected $_setsFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var GroupFactory
     */
    protected $groupFactory;

    /**
     * Undocumented function
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\Product\Type $type
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param \Magento\Catalog\Model\Product\Visibility $visibility
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Xigen\Announce\Model\GroupFactory $groupFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        SetCollectionFactory $setsFactory,
        ProductFactory $productFactory,
        Type $type,
        Status $status,
        Visibility $visibility,
        Registry $coreRegistry,
        ProductCollectionFactory $productCollectionFactory,
        GroupFactory $groupFactory,
        array $data = []
    ) {
        $this->_setsFactory = $setsFactory;
        $this->_productFactory = $productFactory;
        $this->_type = $type;
        $this->_status = $status;
        $this->_visibility = $visibility;
        $this->coreRegistry = $coreRegistry;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->groupFactory = $groupFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('announce_group_edit_tab_product_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setTitle(__('Products'));
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->canShowTab()) {
            $this->setDefaultFilter(['in_products' => 1]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Products');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Products');
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
        $collection = $this->productCollectionFactory->create()
            ->addFieldToSelect("*");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     * @return $this
     */
    protected function _prepareColumns()
    {
        if (!$this->isReadonly()) {
            $this->addColumn(
                'in_products',
                [
                    'type' => 'checkbox',
                    'name' => 'in_products',
                    'values' => $this->_getSelectedProducts(),
                    'align' => 'center',
                    'index' => 'entity_id',
                    'header_css_class' => 'col-select',
                    'column_css_class' => 'col-select'
                ]
            );
        }

        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );

        $this->addColumn(
            'type',
            [
                'header' => __('Type'),
                'index' => 'type_id',
                'type' => 'options',
                'options' => $this->_type->getOptionArray(),
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type'
            ]
        );

        $sets = $this->_setsFactory->create()->setEntityTypeFilter(
            $this->_productFactory->create()->getResource()->getTypeId()
        )->load()->toOptionHash();

        $this->addColumn(
            'set_name',
            [
                'header' => __('Attribute Set'),
                'index' => 'attribute_set_id',
                'type' => 'options',
                'options' => $sets,
                'header_css_class' => 'col-attr-name',
                'column_css_class' => 'col-attr-name'
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->_status->getOptionArray(),
                'header_css_class' => 'col-status',
                'column_css_class' => 'col-status'
            ]
        );

        $this->addColumn(
            'visibility',
            [
                'header' => __('Visibility'),
                'index' => 'visibility',
                'type' => 'options',
                'options' => $this->_visibility->getOptionArray(),
                'header_css_class' => 'col-visibility',
                'column_css_class' => 'col-visibility'
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
                'header_css_class' => 'col-sku',
                'column_css_class' => 'col-sku'
            ]
        );

        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'currency_code' => (string)$this->_scopeConfig->getValue(
                    Currency::XML_PATH_CURRENCY_BASE,
                    ScopeInterface::SCOPE_STORE
                ),
                'index' => 'price',
                'header_css_class' => 'col-price',
                'column_css_class' => 'col-price'
            ]
        );

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
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
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
     * Retrieve selected related products
     * @return array
     */
    public function _getSelectedProducts()
    {
        return array_keys($this->getSelectedProducts());
    }

    /**
     * Retrieve related message
     * @return array
     */
    public function getSelectedProducts()
    {
        $products = [];
        $collection = [];

        if ($selected = $this->coreRegistry->registry('xigen_announce_group')) {
            $collection = $selected->getProductsCollection();
        } elseif ($groupId = $this->getRequest()->getParam('group_id')) {
            if ($selected = $this->groupFactory->create()->load($groupId)) {
                $collection = $selected->getProductsCollection();
            }
        }

        foreach ($collection as $product) {
            $products[$product->getId()] = ['sku' => $product->getSku()];
        }

        return $products;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productGrid', ['_current' => true]);
    }
}
