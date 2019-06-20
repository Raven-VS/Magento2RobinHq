<?php

namespace Emico\RobinHq\Mapper;

use DateTimeImmutable;
use Emico\RobinHq\DataProvider\PanelView\CustomerPanelViewProviderInterface;
use Emico\RobinHqLib\Model\Customer;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Address\AbstractAddress;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */
class CustomerFactory
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var CustomerPanelViewProviderInterface
     */
    private $panelViewProvider;

    /**
     * CustomerFactory constructor.
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CustomerPanelViewProviderInterface $panelViewProvider
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CustomerPanelViewProviderInterface $panelViewProvider
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->panelViewProvider = $panelViewProvider;
    }

    /**
     * @param CustomerInterface $customer
     * @param bool $includePanelView
     * @return Customer
     * @throws \Exception
     */
    public function createRobinCustomer(CustomerInterface $customer, bool $includePanelView = false): Customer
    {
        $robinCustomer = new Customer($customer->getEmail());
        $robinCustomer->setCustomerSince(new DateTimeImmutable($customer->getCreatedAt()));
        $robinCustomer->setName($this->getFullName($customer));

        foreach ($this->panelViewProvider->getData($customer) as $label => $value) {
            //@todo translate label
            $robinCustomer->addPanelViewItem($label, $value);
        }

        $this->addAddressInformation($customer, $robinCustomer, $includePanelView);
        $this->addOrderInformation($customer, $robinCustomer);

        return $robinCustomer;
    }

    /**
     * @param CustomerInterface $customer
     * @return string
     */
    protected function getFullName(CustomerInterface $customer): string
    {
        $fullName = $customer->getFirstname();
        if ($customer->getMiddlename()) {
            $fullName .= ' ' . $customer->getMiddlename();
        }
        $fullName .= ' ' . $customer->getLastname();
        return $fullName;
    }

    /**
     * @param CustomerInterface $customer
     * @param Customer $robinCustomer
     */
    protected function addOrderInformation(CustomerInterface $customer, Customer $robinCustomer): void
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(OrderInterface::CUSTOMER_ID, $customer->getId())
            //->addFilter(OrderInterface::STATE, [Order::STATE_COMPLETE, Order::STATE_PROCESSING], 'in')
            ->create();

        $customerOrders = $this->orderRepository->getList($searchCriteria)->getItems();
        $orderCount = count($customerOrders);
        if ($orderCount === 0) {
            return;
        }

        $robinCustomer->setOrderCount($orderCount);

        /** @var OrderInterface $lastOrder */
        $lastOrder = end($customerOrders);
        $robinCustomer->setCurrency($lastOrder->getBaseCurrencyCode());

        $totalSpent = 0;
        foreach ($customerOrders as $order) {
            $totalSpent += $order->getGrandTotal();
        }
        $robinCustomer->setTotalRevenue($totalSpent);
    }

    /**
     * @param CustomerInterface $customer
     * @param Customer $robinCustomer
     * @param bool $includePanelView
     */
    protected function addAddressInformation(
        CustomerInterface $customer,
        Customer $robinCustomer,
        bool $includePanelView
    ): void {
        $address = $this->getDefaultAddress($customer);
        if ($address === null) {
            return;
        }

        $robinCustomer->setPhoneNumber($address->getTelephone());

        if ($includePanelView) {
            $street = $address->getStreet();
            if (\is_array($street)) {
                $street = implode("\n", $street);
            }

            $robinCustomer->addPanelViewItem('street', $street);
            $robinCustomer->addPanelViewItem('postalCode', $address->getPostcode());
            $robinCustomer->addPanelViewItem('city', $address->getCity());
            $robinCustomer->addPanelViewItem('telephone', $address->getTelephone());
        }
    }

    /**
     * @param CustomerInterface $customer
     * @return AddressInterface|null
     */
    protected function getDefaultAddress(CustomerInterface $customer): ?AddressInterface
    {
        $customerAddresses = $customer->getAddresses();
        if (count($customerAddresses) === 0) {
            return null;
        }

        $defaultAddress = null;
        foreach ($customerAddresses as $address) {
            if ($address->isDefaultBilling()) {
                $defaultAddress = $address;
            }
            if ($defaultAddress === null && $address->isDefaultShipping()) {
                $defaultAddress = $address;
            }
        }

        return $defaultAddress ?? $customerAddresses[0];
    }

    /**
     * @param CustomerInterface $customer
     * @return AddressInterface|null
     */
    protected function getShippingAddress(CustomerInterface $customer): ?AbstractAddress
    {
        foreach ($customer->getAddresses() as $address) {
            if ($address->isDefaultShipping()) {
                return $address;
            }
        }
        return null;
    }
}