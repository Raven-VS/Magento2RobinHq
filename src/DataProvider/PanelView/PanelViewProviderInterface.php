<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;

use Magento\Customer\Api\Data\CustomerInterface;

interface PanelViewProviderInterface
{
    public function getItems(CustomerInterface $customer): array;
}