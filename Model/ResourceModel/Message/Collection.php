<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel\Message;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'message_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Xigen\Announce\Model\Message::class,
            \Xigen\Announce\Model\ResourceModel\Message::class
        );
    }
}
