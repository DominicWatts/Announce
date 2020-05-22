<?php

declare(strict_types=1);

namespace Xigen\Announce\Block\Adminhtml\Group\Edit\Tab\Grid\Renderer;

// phpcs:ignoreFile

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Xigen\Announce\Helper\Data;

/**
 * Adminhtml group message grid status renderer
 */
class Status extends AbstractRenderer
{
    /**
     * @var array
     */
    protected static $_statuses;

    /**
     * Constructor for Grid Renderer Status
     *
     * @return void
     */
    protected function _construct()
    {
        // phpcs:disable
        self::$_statuses = [
            Data::ENABLED => __(Data::ENABLED_TEXT),
            Data::DISABLED => __(Data::DISABLED_TEXT),
        ];
        // phpcs:enable
        parent::_construct();
    }

    /**
     * @param \Magento\Framework\DataObject $row
     * @return \Magento\Framework\Phrase
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        return __($this->getStatus($row->getStatus()));
    }

    /**
     * @param string $status
     * @return \Magento\Framework\Phrase
     */
    public static function getStatus($status)
    {
        if (isset(self::$_statuses[$status])) {
            return self::$_statuses[$status];
        }

        return __('Unknown');
    }
}
