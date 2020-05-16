<?php

declare(strict_types=1);

namespace Xigen\Announce\Block;

use Magento\Framework\View\Element\Template\Context;

class Annoucement extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'Xigen_Announce::announce.phtml';

    /**
     *
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function displayAnnounce()
    {
        return true;
    }
}
