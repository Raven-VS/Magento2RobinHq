<?php

namespace Emico\RobinHq\Observer;

use Emico\RobinHq\Mapper\CustomerFactory;
use Emico\RobinHqLib\Service\CustomerService;
use Emico\RobinHqLib\Model\Customer as RobinCustomer;
use Magento\Customer\Model\Customer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

class CustomerSaveAfterObserver implements ObserverInterface
{
    /**
     * @var CustomerService
     */
    private $customerService;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CustomerSaveAfterObserver constructor.
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService, LoggerInterface $logger)
    {
        $this->customerService = $customerService;
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @throws Exception
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getData('customer');
        if (!$customer instanceof Customer) {
            return;
        }

        //@todo we need to use mapper here, but we don't have an CustomerInterface instance here :-(
        $robinCustomer = new RobinCustomer($customer->getEmail());

        $this->logger->debug(sprintf('Publishing RobinHQ POST for customer'), [
            'customerId' => $customer->getId(),
        ]);
        $this->customerService->postCustomer($robinCustomer);
    }
}