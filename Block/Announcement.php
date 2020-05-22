<?php

declare(strict_types=1);

namespace Xigen\Announce\Block;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template\Context;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Helper\Fetch;
use Xigen\Announce\Helper\Stats;

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
     * @var Stats
     */
    protected $statsHelper;

    /**
     * @var FilterProvider
     */
    protected $filterProvider;

    /**
     * Announcement constructor.
     * @param Context $context
     * @param Fetch $fetchHelper
     * @param Stats $statsHelper
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        Context $context,
        Fetch $fetchHelper,
        Stats $statsHelper,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->fetchHelper = $fetchHelper;
        $this->statsHelper = $statsHelper;
        $this->filterProvider = $filterProvider;
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
     * @return Stats
     */
    public function getStatsHelper()
    {
        return $this->statsHelper;
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGeneratedBlockId($entity, $type = DATA::GROUP)
    {
        $blockId = $type;
        if ($this->getPosition()) {
            $blockId .= __(
                "-%1",
                $this->getPosition()
            );
        }

        if ($this->getCategoryPosition()) {
            $blockId .= __(
                "-%1",
                $this->getCategoryPosition()
            );
        }

        if ($id = $entity->getGroupId() ?: $entity->getMessageId() ?: null) {
            $blockId .= __(
                "-%1",
                $id
            );
        }

        return $blockId;
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGenerateBlockClass($entity, $type = DATA::GROUP)
    {
        $blockClass = '';
        if ($this->getPosition()) {
            $blockClass .= __(
                "announce-{$type}__%1",
                $this->getPosition()
            );
        }

        if ($this->getCategoryPosition()) {
            $blockClass .= __(
                "announce-{$type}__%1",
                $this->getPosition()
            );
        }

        if ($entity->getCssclass()) {
            $blockClass .= __(
                " %1",
                $entity->getCssclass()
            );
        }

        return $blockClass;
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

    /**
     * Filter content to allow for WYSIWYG elements
     * @param $content
     * @throws \Exception
     */
    public function filter($content)
    {
        return $this->filterProvider->getBlockFilter()->filter($content);
    }
}
