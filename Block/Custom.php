<?php

declare(strict_types=1);

namespace Xigen\Announce\Block;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template\Context;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Helper\Fetch;

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
     * @var FilterProvider
     */
    protected $filterProvider;

    /**
     * Announcement constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        Fetch $fetchHelper,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->fetchHelper = $fetchHelper;
        $this->filterProvider = $filterProvider;
        parent::__construct($context, $fetchHelper, $filterProvider, $data);
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
