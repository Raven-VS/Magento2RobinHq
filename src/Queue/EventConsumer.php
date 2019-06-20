<?php
/**
 * Tweakwise & Emico (https://www.tweakwise.com/ & https://www.emico.nl/) - All Rights Reserved
 *
 * @copyright Copyright (c) 2017-%year% Tweakwise.com B.V. (https://www.tweakwise.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Emico\TweakwisePim\Queue\Consumer;

use Emico\TweakwisePim\EntityUpdateService;
use Emico\TweakwisePim\Queue\Message\UpdateMessage;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class EventConsumer
{
    /**
     * @var EntityUpdateService
     */
    private $updateService;

    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * UpdateConsumer constructor.
     *
     * @param EntityUpdateService $updateService
     */
    public function __construct(EntityUpdateService $updateService, LoggerInterface $log)
    {
        $this->updateService = $updateService;
        $this->log = $log;
    }

    /**
     * @param UpdateMessage $message
     * @throws LocalizedException
     */
    public function processMessage(UpdateMessage $message): void
    {
        $this->log->debug(
            sprintf(
                'Handle update message %s %s (%s)',
                $message->getOperation(),
                $message->getEntityName(),
                $message->getEntityId()
            ),
            [
                'operation' => $message->getOperation(),
                'entityType' => $message->getEntityName(),
                'entityId' => $message->getEntityId(),
            ]
        );
        $this->updateService->updateById($message->getEntityName(), $message->getEntityId(), $message->isForce());
    }
}
