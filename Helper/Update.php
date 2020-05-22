<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Psr\Log\LoggerInterface;
use Xigen\Announce\Api\MessageRepositoryInterface;

class Update extends AbstractHelper
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepositoryInterface;

    /**
     * Update constructor.
     * @param Context $context
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        MessageRepositoryInterface $messageRepositoryInterface
    ) {
        $this->logger = $logger;
        $this->messageRepositoryInterface = $messageRepositoryInterface;
        parent::__construct($context);
    }

    /**
     * Clear message batch as group ID
     * @param array $MessageInterface
     * @param int $groupId
     * @return void
     */
    public function setMessagesAsNull($messageInterface = [], $groupId = null)
    {
        foreach ($messageInterface as $message) {
            try {
                if ($groupId && $message->getGroupId() == $groupId) {
                    $message->setGroupId(0);
                } else {
                    $message->setGroupId(0);
                }
                $this->messageRepositoryInterface->save($message);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }

    /**
     * Set message batch as group ID
     * @param array $MessageInterface
     * @param int $groupId
     * @return void
     */
    public function setMessagesAsGroupId($messageInterface = [], $groupId = null)
    {
        foreach ($messageInterface as $message) {
            try {
                $message->setGroupId($groupId);
                $this->messageRepositoryInterface->save($message);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }
    }
}
