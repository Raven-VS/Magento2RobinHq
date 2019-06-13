<?php
namespace Emico\RobinHq\Controller\Api;

use Emico\RobinHqLib\Server\RestApiServer;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Customer extends Action
{
    /**
     * @var RestApiServer
     */
    private $restApiServer;

    /**
     * Customer constructor.
     * @param Context $context
     * @param RestApiServer $restApiServer
     */
    public function __construct(
        Context $context,
        RestApiServer $restApiServer
    ) {
        parent::__construct($context);
        $this->restApiServer = $restApiServer;
    }

    public function execute()
    {
        exit('henkie');
    }
}