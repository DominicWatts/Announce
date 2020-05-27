<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const ORDERLY = 1;
    const RANDOM = 2;
    const ORDERLY_TEXT = 1;
    const RANDOM_TEXT = 2;

    const ENABLED = 1;
    const DISABLED = 0;
    const ENABLED_TEXT = "Enabled";
    const DISABLED_TEXT = "Disabled";

    const GROUP = 'group';
    const MESSAGE = 'message';

    const OPENING_TAG = 'start';
    const CLOSING_TAG = 'end';

    const GROUP_TAB = 'general';
    const MESSAGE_TAB = 'message';
    const PRODUCT_TAB = 'product';

    const FIRST_PAGE = 1;

    const REGISTRY_KEY = 'announce_group_id';
}
