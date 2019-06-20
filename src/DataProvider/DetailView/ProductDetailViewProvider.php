<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHq\DataProvider\DetailView;


use Emico\RobinHqLib\Model\Order\DetailsView;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Sales\Api\Data\OrderInterface;

class ProductDetailViewProvider implements DetailViewProviderInterface
{
    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * ProductDetailViewProvider constructor.
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(PriceCurrencyInterface $priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;
    }

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

                // @todo custom attributes
                'merk' => 'PME Legend',
				'maat' => 'W:34 L:18',

                'price' => $this->priceCurrency->format($item->getPriceInclTax(), false),
                'totalIncludingTax' => $this->priceCurrency->format($item->getRowTotalInclTax(), false)
            ];
        }
        $detailView = new DetailsView(DetailsView::DISPLAY_MODE_COLUMNS, $orderItemsData);
        $detailView->setCaption(__('products'));
        return [$detailView];
    }
}