<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Emico\RobinHqLib\Model\Order\DetailsView;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Sales\Api\Data\OrderInterface;

class NullPanelViewProvider implements PanelViewProviderInterface
{
    /**
     * @param CustomerInterface $customer
     * @return array
     * @throws \Exception
     */
    public function getItems(CustomerInterface $customer): array
    {
        return [];
    }
}