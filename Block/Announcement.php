<?php

declare(strict_types=1);

namespace Xigen\Announce\Block;

use Magento\Framework\View\Element\Template\Context;
use Xigen\Announce\Helper\Data;
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
     * @return Fetch
     */
    public function getFetchHelper()
    {
        return $this->fetchHelper;
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGeneratedBlockId($entity, $type = DATA::GROUP)
    {
        return __(
            "$type-%1-%2-%3",
            $this->getPosition(),
            $this->getCategoryPosition(),
            $entity->getGroupId() ?: $entity->getMessageId() ?: null
        );
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGenerateBlockClass($entity, $type = DATA::GROUP)
    {
        return __(
            "announce-{$type}__%1 announce-{$type}__%2%3",
            $this->getPosition(),
            $this->getCategoryPosition(),
            $entity->getCssclass() ? ' ' . $entity->getCssclass() : null
        );
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGeneratedComment($type = DATA::OPENING_TAG)
    {
        return __(
            "<!-- $type : %1 %2 //-->",
            $this->getPosition(),
            $this->getCategoryPosition()
        );
    }
}
