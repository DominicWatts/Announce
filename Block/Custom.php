<?php

declare(strict_types=1);

namespace Xigen\Announce\Block;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template\Context;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Helper\Fetch;
use Xigen\Announce\Helper\Stats;

class Custom extends Announcement
{
    /**
     * @var string
     */
    protected $_template = 'Xigen_Announce::custom.phtml';

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
     * Custom constructor.
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
        parent::__construct($context, $fetchHelper, $statsHelper, $filterProvider, $data);
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGeneratedBlockId($entity, $type = DATA::GROUP)
    {
        $blockId = $type;
        if ($this->getGroupId()) {
            $blockId .= __(
                "-announce-custom-%1",
                $this->getGroupId()
            );
        }

        return $blockId;
    }

    /**
     * @param $entity
     * @param string $type
     * @return \Magento\Framework\Phrase
     */
    public function getGenerateBlockClass($entity, $type = DATA::MESSAGE)
    {
        $blockClass = '';
        if ($this->getGroupId()) {
            $blockClass .= __(
                "announce-{$type}__custom-%1",
                $this->getGroupId()
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
}
