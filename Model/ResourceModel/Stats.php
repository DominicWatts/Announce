<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\ResourceModel;

class Stats extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('xigen_announce_stats', 'stats_id');
    }
}
