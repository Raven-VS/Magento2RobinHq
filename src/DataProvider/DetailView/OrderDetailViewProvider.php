<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Emico\RobinHqLib\Model\Order\DetailsView;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;

class OrderDetailViewProvider implements DetailViewProviderInterface
{
    /**
     * @param OrderInterface $order
     * @return array
     * @throws \Exception
     */
    public function getItems(OrderInterface $order): array
    {
        /** @var Order $order */
        $data = [
            //@todo translate labels
            'ordernumber' => $order->getIncrementId(),
            'store' => $order->getStore()->getCode(),
            'orderdate' => (new \DateTimeImmutable($order->getCreatedAt()))->format('d-m-Y'),
            'status' => $order->getStatus(),
            'payment method' => $order->getPayment() ? $order->getPayment()->getMethod() : 'Unknown',


            // @todo custom attributes
            //"sherpa_odernummer" => "80320000",
        ];

        if ($order instanceof Order) {
            /** @var InvoiceInterface $lastInvoice */
            $lastInvoice = $order->getInvoiceCollection()->getLastItem();
            if ($lastInvoice->getEntityId()) {
                $data['invoicedate'] = (new \DateTimeImmutable($lastInvoice->getCreatedAt()))->format('d-m-Y');
            }
        }

        $detailView = new DetailsView(DetailsView::DISPLAY_MODE_ROWS, $data);
        $detailView->setCaption(__('details'));
        return [$detailView];
    }
}