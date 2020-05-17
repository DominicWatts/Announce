<?php

declare(strict_types=1);

namespace Xigen\Announce\Block;

use Magento\Framework\View\Element\Template\Context;
use Xigen\Announce\Helper\Fetch;

class Announcement extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'Xigen_Announce::announce.phtml';

    /**
     * @var Fetch
     */
    protected $fetchHelper;

    /**
     * Announcement constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        Fetch $fetchHelper,
        array $data = []
    ) {
        $this->fetchHelper = $fetchHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getFetchHelper()
    {
        return $this->fetchHelper;
    }
}
