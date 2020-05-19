<?php

namespace Xigen\Announce\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Position implements OptionSourceInterface
{
    /**
     * Options getter
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Please choose position'),
                'value' => '',
            ],
            [
                'label' => __('Default for using in CMS page template'),
                'value' => [
                    ['value' => 'custom', 'label' => __('Custom')],
                ],
            ],
            [
                'label' => __('Popular positions'),
                'value' => [
                    ['value' => 'cms-page-content-top', 'label' => __('Homepage-Content-Top')],
                    ['value' => 'contact-content-top', 'label' => __('Contact-Us-Content-Top')],
                    ['value' => 'contact-content-form', 'label' => __('Contact-Us-Content-Form')],
                ],
            ],
            [
                'label' => __('General (will be displayed on all pages)'),
                'value' => [
                    ['value' => 'sidebar-right-top', 'label' => __('Sidebar-Top-Right')],
                    ['value' => 'sidebar-right-bottom', 'label' => __('Sidebar-Bottom-Right')],
                    ['value' => 'sidebar-left-top', 'label' => __('Sidebar-Top-Left')],
                    ['value' => 'sidebar-left-bottom', 'label' => __('Sidebar-Bottom-Left')],
                    ['value' => 'content-top', 'label' => __('Content-Top')],
                    ['value' => 'menu-top', 'label' => __('Menu-Top')],
                    ['value' => 'menu-bottom', 'label' => __('Menu-Bottom')],
                    ['value' => 'page-bottom', 'label' => __('Page-Bottom')],
                ],
            ],
            [
                'label' => __('Catalog and product'),
                'value' => [
                    ['value' => 'catalog-sidebar-right-top', 'label' => __('Catalog-Sidebar-Top-Right')],
                    ['value' => 'catalog-sidebar-right-bottom', 'label' => __('Catalog-Sidebar-Bottom-Right')],
                    ['value' => 'catalog-sidebar-left-top', 'label' => __('Catalog-Sidebar-Top-Left')],
                    ['value' => 'catalog-sidebar-left-bottom', 'label' => __('Catalog-Sidebar-Bottom-Left')],
                    ['value' => 'catalog-content-top', 'label' => __('Catalog-Content-Top')],
                    ['value' => 'catalog-menu-top', 'label' => __('Catalog-Menu-Top')],
                    ['value' => 'catalog-menu-bottom', 'label' => __('Catalog-Menu-Bottom')],
                    ['value' => 'catalog-page-bottom', 'label' => __('Catalog-Page-Bottom')],
                    ['value' => 'catalog-columns-top', 'label' => __('Catalog-Columns-Top')],
                ],
            ],
            [
                'label' => __('Category only'),
                'value' => [
                    ['value' => 'category-sidebar-right-top', 'label' => __('Category-Sidebar-Top-Right')],
                    ['value' => 'category-sidebar-right-bottom', 'label' => __('Category-Sidebar-Bottom-Right')],
                    ['value' => 'category-sidebar-left-top', 'label' => __('Category-Sidebar-Top-Left')],
                    ['value' => 'category-sidebar-left-bottom', 'label' => __('Category-Sidebar-Bottom-Left')],
                    ['value' => 'category-content-top', 'label' => __('Category-Content-Top')],
                    ['value' => 'category-menu-top', 'label' => __('Category-Menu-Top')],
                    ['value' => 'category-menu-bottom', 'label' => __('Category-Menu-Bottom')],
                    ['value' => 'category-page-bottom', 'label' => __('Category-Page-Bottom')],
                ],
            ],
            [
                'label' => __('Product only'),
                'value' => [
                    ['value' => 'product-sidebar-right-top', 'label' => __('Product-Sidebar-Top-Right')],
                    ['value' => 'product-sidebar-right-bottom', 'label' => __('Product-Sidebar-Bottom-Right')],
                    ['value' => 'product-sidebar-left-top', 'label' => __('Product-Sidebar-Top-Left')],
                    ['value' => 'product-content-top', 'label' => __('Product-Content-Top')],
                    ['value' => 'product-menu-top', 'label' => __('Product-Menu-Top')],
                    ['value' => 'product-menu-bottom', 'label' => __('Product-Menu-Bottom')],
                    ['value' => 'product-page-bottom', 'label' => __('Product-Page-Bottom')],
                ],
            ],
            [
                'label' => __('Customer'),
                'value' => [
                    ['value' => 'customer-content-top', 'label' => __('Customer-Content-Top')],
                    ['value' => 'customer-sidebar-main-top', 'label' => __('Customer-Sidebar-Main-Top')],
                    ['value' => 'customer-sidebar-main-bottom', 'label' => __('Customer-Sidebar-Main-Bottom')],
                ],
            ],
            [
                'label' => __('Cart & Checkout'),
                'value' => [
                    ['value' => 'cart-content-top', 'label' => __('Cart-Content-Top')],
                    ['value' => 'checkout-content-top', 'label' => __('Checkout-Content-Top')],
                ],
            ],
        ];
    }

    /**
     * Get options in "key-value" format
     * @return array
     */
    public function toArray()
    {
        return [
            '' => __('Please choose position'),
            // Default for using in CMS page template
            'custom' => __('Custom'),
            // Popular positions
            'cms-page-content-top' => __('Homepage-Content-Top'),
            'contact-content-top' => __('Contact-Us-Content-Top'),
            'contact-content-form' => __('Contact-Us-Content-Form'),
            // General (will be displayed on all pages)
            'sidebar-right-top' => __('Sidebar-Top-Right'),
            'sidebar-right-bottom' => __('Sidebar-Bottom-Right'),
            'sidebar-left-top' => __('Sidebar-Top-Left'),
            'sidebar-left-bottom' => __('Sidebar-Bottom-Left'),
            'content-top' => __('Content-Top'),
            'menu-top' => __('Menu-Top'),
            'menu-bottom' => __('Menu-Bottom'),
            'page-bottom' => __('Page-Bottom'),
            // Catalog and product
            'catalog-sidebar-right-top' => __('Catalog-Sidebar-Top-Right'),
            'catalog-sidebar-right-bottom' => __('Catalog-Sidebar-Bottom-Right'),
            'catalog-sidebar-left-top' => __('Catalog-Sidebar-Top-Left'),
            'catalog-sidebar-left-bottom' => __('Catalog-Sidebar-Bottom-Left'),
            'catalog-content-top' => __('Catalog-Content-Top'),
            'catalog-menu-top' => __('Catalog-Menu-Top'),
            'catalog-menu-bottom' => __('Catalog-Menu-Bottom'),
            'catalog-page-bottom' => __('Catalog-Page-Bottom'),
            'catalog-columns-top' => __('Catalog-Columns-Top'),
            // Category only
            'category-sidebar-right-top' => __('Category-Sidebar-Top-Right'),
            'category-sidebar-right-bottom' => __('Category-Sidebar-Bottom-Right'),
            'category-sidebar-left-top' => __('Category-Sidebar-Top-Left'),
            'category-sidebar-left-bottom' => __('Category-Sidebar-Bottom-Left'),
            'category-content-top' => __('Category-Content-Top'),
            'category-menu-top' => __('Category-Menu-Top'),
            'category-menu-bottom' => __('Category-Menu-Bottom'),
            'category-page-bottom' => __('Category-Page-Bottom'),
            // Product only
            'product-sidebar-right-top' => __('Product-Sidebar-Top-Right'),
            'product-sidebar-right-bottom' => __('Product-Sidebar-Bottom-Right'),
            'product-sidebar-left-top' => __('Product-Sidebar-Top-Left'),
            'product-content-top' => __('Product-Content-Top'),
            'product-menu-top' => __('Product-Menu-Top'),
            'product-menu-bottom' => __('Product-Menu-Bottom'),
            'product-page-bottom' => __('Product-Page-Bottom'),
            // Customer
            'customer-content-top'=> __('Customer-Content-Top'),
            'customer-sidebar-main-top' => __('Customer-Sidebar-Main-Top'),
            'customer-sidebar-main-bottom' => __('Customer-Sidebar-Main-Bottom'),
            // Cart & Checkout
            'cart-content-top' => __('Cart-Content-Top'),
            'checkout-content-top' => __('Checkout-Content-Top'),
        ];
    }
}
