<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Magento\Customer\Api\Data\CustomerInterface;

class AggregatePanelViewProvider implements PanelViewProviderInterface
{
    /**
     * @var array|PanelViewProviderInterface[]
     */
    private $providers;

    /**
     * AggregateDetailViewProvider constructor.
     * @param array $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @param CustomerInterface $customer
     * @return array
     */
    public function getItems(CustomerInterface $customer): array
    {
        $providerItems = [];
        foreach ($this->providers as $provider) {
            $providerItems[] = $provider->getItems($customer);
        }
        return array_merge(...$providerItems);
    }
}