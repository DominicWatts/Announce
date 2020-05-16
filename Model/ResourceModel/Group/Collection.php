<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel\Group;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'group_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Xigen\Announce\Model\Group::class,
            \Xigen\Announce\Model\ResourceModel\Group::class
        );
    }
}
