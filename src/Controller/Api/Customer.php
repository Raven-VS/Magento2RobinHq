<?php
namespace Emico\RobinHq\Controller\Api;

use Magento\Framework\App\Action\Action;

class Customer extends Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        exit('henkie');
        return $this->_pageFactory->create();
    }
}