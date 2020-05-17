<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const ORDERLY = 1;
    const RANDOM = 2;

    const ENABLED = 1;
    const DISABLED = 0;

    const ALL_STORE_VIEWS = 0;
}
