<?php

declare(strict_types=1);

namespace Xigen\Announce\Helper;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

class Customer extends AbstractHelper
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Customer constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        StoreManagerInterface $storeManager
    ) {
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        if (!$this->customerSession->isLoggedIn()) {
            return false;
        }
        return true;
    }

    /**
     * Get customer email
     * @return string
     */
    public function getEmail()
    {
        if (!$this->isLoggedIn()) {
            return '';
        }
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->customerSession->getCustomerDataObject();
        return $customer->getEmail();
    }

    /**
     * Get customer group ID
     * @return string
     */
    public function getGroupId()
    {
        if (!$this->isLoggedIn()) {
            return '';
        }
        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->customerSession->getCustomerDataObject();
        return $customer->getGroupId();
    }

    /**
     * Get store identifier
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * Get website identifier
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getWebsiteId()
    {
        return $this->storeManager->getStore()->getWebsiteId();
    }
}
