<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Emico\RobinHqLib\Model\Order\DetailsView;
use Magento\Sales\Api\Data\OrderInterface;

class TotalDetailViewProvider implements DetailViewProviderInterface
{
    /**
     * @param OrderInterface $order
     * @return array
     */
    public function getItems(OrderInterface $order): array
    {
        //@todo format price
        $detailViewData = [
            'subtotal_(incl_VAT)' => $order->getSubtotalInclTax(),
            'shippingcost' => $order->getShippingInclTax(),
            'discounts_(incl_VAT)' => $order->getDiscountAmount(),
            'VAT' => $order->getSubtotalInclTax() - $order->getSubtotal(),
            'total_(incl_VAT)' => $order->getGrandTotal(),
            'payed' => $order->getPayment() ? ($order->getPayment()->getAmountPaid() ?? 0) : 0,
            'refunded' => $order->getTotalRefunded() ?? 0,
            'orderwaarde' => 0 // @todo Wat is dit??
        ];
        $detailView = new DetailsView(DetailsView::DISPLAY_MODE_ROWS, $detailViewData);
        $detailView->setCaption('totals'); //@todo translation
        return [$detailView];
    }
}