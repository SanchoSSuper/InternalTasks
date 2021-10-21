<?php

namespace Magento\Status\Block\Html;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Status\Model\Config\Source\CustomerStatus;

class Header extends \Magento\Theme\Block\Html\Header
{
    /**
     * Current template name
     *
     * @var string
     */
    protected $_template = 'Magento_Status::html/header.phtml';

    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @var CustomerStatus
     */
    private CustomerStatus $customerStatus;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param Template\Context $context
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerStatus $customerStatus
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        CustomerStatus $customerStatus,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->customerStatus = $customerStatus;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        try {
            $customerId = $this->customerSession->getCustomerId();
            $customerData = $this->customerRepository->getById($customerId);
            $customerStatus = $customerData->getCustomAttribute('customer_status');
            $statusId = $customerStatus ? $customerStatus->getValue() : null;
            $result = $statusId ? $this->customerStatus->toOptionArray()[$statusId]['label']->getText() : null;
        } catch (NoSuchEntityException | LocalizedException $e) {
            $result = 'ERROR';
        }

        return $result;
    }
}
