<?php

namespace Magento\Status\Block\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Status\Model\Config\Source\CustomerStatus;

class Status extends Template
{
    /**
     * @var CustomerStatus
     */
    private CustomerStatus $customerStatus;

    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param Template\Context $context
     * @param CustomerStatus $customerStatus
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CustomerStatus $customerStatus,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerStatus = $customerStatus;
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return mixed
     */
    public function isExists()
    {
        try {
            $customerId = $this->customerSession->getCustomerId();
            $customerData = $this->customerRepository->getById($customerId);
            $customerStatus = $customerData->getCustomAttribute('customer_status');
            $statusId = $customerStatus ? $customerStatus->getValue() : null;
            $result = $statusId ?: false;
        } catch (NoSuchEntityException | LocalizedException $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->customerStatus->toOptionArray();
    }
}
