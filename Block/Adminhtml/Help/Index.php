<?php

declare(strict_types=1);

namespace Xigen\Announce\Block\Adminhtml\Help;

use Magento\Backend\Block\Template\Context;

// phpcs:ignoreFile

class Index extends \Magento\Backend\Block\Template
{
    /**
     * Constructor
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
