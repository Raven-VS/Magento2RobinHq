<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Emico\RobinHqLib\Model\Order\DetailsView;
use Magento\Sales\Api\Data\OrderInterface;

class OrderDetailViewProvider implements DetailViewProviderInterface
{
    /**
     * @param OrderInterface $order
     * @return array
     * @throws \Exception
     */
    public function getItems(OrderInterface $order): array
    {
        $data = [
            'Ordernumber' => $order->getIncrementId(),
            'Store' => "PME Legend EN", //@todo
            'Orderdate' => (new \DateTimeImmutable($order->getCreatedAt()))->format('d-m-Y'),
            'Status' => $order->getStatus(),
            'Payment method' => $order->getPayment() ? $order->getPayment()->getMethod() : 'Unknown',
            // @todo implement Custom fields
            "sherpa_odernummer" => "80320000",
            'Invoicedate' => '02-01-2018', // @todo hoe invoice date ophalen?
        ];

        $detailView = new DetailsView(DetailsView::DISPLAY_MODE_ROWS, $data);
        $detailView->setCaption('details'); //@todo translation
        return [$detailView];
    }
}