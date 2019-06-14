<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Emico\RobinHqLib\Model\Order\DetailsView;
use Magento\Sales\Api\Data\OrderInterface;

class ProductDetailViewProvider implements DetailViewProviderInterface
{
    /**
     * @param OrderInterface $order
     * @return array
     */
    public function getItems(OrderInterface $order): array
    {
        $orderItemsData = [];
        foreach ($order->getItems() as $item) {
            // @todo translation of array keys
            $orderItemsData[] = [
                'artikelnr_(SKU)' => $item->getSku(),
                'article name' => $item->getName(),
                'quantity' => $item->getQtyOrdered(),

                // @todo custom attributen. Ergens configureerbaar?
                'merk' => 'PME Legend',
				'maat' => 'W:34 L:18',
				'status' => 'Verzonden', // @todo Waar komt status vandaan per item?

                //@todo formatting
                'price' => $item->getPriceInclTax(),
                'totalIncludingTax' => $item->getRowTotalInclTax()


                
            ];
        }
        $detailView = new DetailsView(DetailsView::DISPLAY_MODE_COLUMNS, $orderItemsData);
        $detailView->setCaption('products'); //@todo translation
        return [$detailView];
    }
}