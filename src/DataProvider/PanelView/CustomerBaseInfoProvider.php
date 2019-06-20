<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\PanelView;

use Magento\Customer\Api\Data\CustomerInterface;

class CustomerBaseInfoProvider implements CustomerPanelViewProviderInterface
{
    /**
     * @param CustomerInterface $customer
     * @return array
     */
    public function getData(CustomerInterface $customer): array
    {
        return [
            'customerId' => $customer->getId(),
            'firstname' => $customer->getFirstname(),
            'surname' => $customer->getLastname()
        ];
    }
}