<?php
namespace Emico\RobinHq\Controller\Api;

use Emico\RobinHqLib\Server\RestApiServer;
use Magento\Framework\App\Action\Action;

class Customer extends Action
{
    protected $_pageFactory;
    /**
     * @var RestApiServer
     */
    private $restApiServer;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        RestApiServer $restApiServer)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
        $this->restApiServer = $restApiServer;
    }

    public function execute()
    {
        exit('henkie');
        return $this->_pageFactory->create();
    }
}