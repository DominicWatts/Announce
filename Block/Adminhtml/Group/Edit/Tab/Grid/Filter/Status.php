<?php

declare(strict_types=1);

namespace Xigen\Announce\Block\Adminhtml\Group\Edit\Tab\Grid\Filter;

use Magento\Backend\Block\Widget\Grid\Column\Filter\Select;
use Xigen\Announce\Helper\Data;

/**
 * Adminhtml group message grid status filter
 */
class Status extends Select
{
    /**
     * @var array
     */
    protected static $_statuses;

    /**
     * @return void
     */
    protected function _construct()
    {
        // phpcs:disable
        self::$_statuses = [
            null => null,
            Data::ENABLED => __(Data::ENABLED_TEXT),
            Data::DISABLED => __(Data::DISABLED_TEXT),
        ];
        // phpcs:enable
        parent::_construct();
    }

    /**
     * @return array
     */
    protected function _getOptions()
    {
        $options = [];
        foreach (self::$_statuses as $status => $label) {
            $options[] = ['value' => $status, 'label' => __($label)];
        }

        return $options;
    }

    /**
     * @return array|null
     */
    public function getCondition()
    {
        return $this->getValue() === null ? null : ['eq' => $this->getValue()];
    }
}
