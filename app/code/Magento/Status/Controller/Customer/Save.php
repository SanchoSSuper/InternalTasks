<?php

namespace Magento\Status\Controller\Customer;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Data\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;

class Save implements ActionInterface
{
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param RedirectFactory $redirectFactory
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param RequestInterface $request
     */
    public function __construct(
        RedirectFactory $redirectFactory,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        RequestInterface $request
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->request = $request;
    }

    /**
     * @inerhitDoc
     */
    public function execute()
    {
        /** @var Customer $customer */
        $customer = $this->customerRepository->getById($this->customerSession->getCustomerId());
        $customer->setCustomAttribute('customer_status', $this->request->getParam('status_type'));
        $this->customerRepository->save($customer);
        $redirect = $this->redirectFactory->create();

        return $redirect->setPath('status/customer/index/');
    }
}
