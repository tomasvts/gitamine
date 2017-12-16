<?php
declare(strict_types=1);

namespace App\Prooph;

use Prooph\Bundle\ServiceBus\NamedMessageBus;
use Prooph\Bundle\ServiceBus\NamedMessageBusTrait;
use Prooph\Common\Event\ActionEvent;
use Prooph\Common\Event\ActionEventEmitter;
use Prooph\ServiceBus\Exception\RuntimeException;
use Prooph\ServiceBus\MessageBus;

/**
 * Class SynchronousQueryBus
 *
 * @package App\Prooph
 */
class SynchronousQueryBus extends MessageBus implements NamedMessageBus
{
    use NamedMessageBusTrait;
    public const EVENT_PARAM_RESULT = 'query-result';

    /**
     * SynchronousQueryBus constructor.
     *
     * @param null|ActionEventEmitter $actionEventEmitter
     */
    public function __construct(?ActionEventEmitter $actionEventEmitter = null)
    {
        parent::__construct($actionEventEmitter);

        $this->events->attachListener(
            self::EVENT_DISPATCH,
            function (ActionEvent $actionEvent): void {
                $handler = $actionEvent->getParam(self::EVENT_PARAM_MESSAGE_HANDLER);
                if (is_callable($handler)) {
                    $query  = $actionEvent->getParam(self::EVENT_PARAM_MESSAGE);
                    $result = $handler($query);
                    $actionEvent->setParam(self::EVENT_PARAM_RESULT, $result);
                    $actionEvent->setParam(self::EVENT_PARAM_MESSAGE_HANDLED, true);
                }
            },
            self::PRIORITY_INVOKE_HANDLER
        );

        $this->events->attachListener(
            self::EVENT_DISPATCH,
            function (ActionEvent $actionEvent): void {
                if ($actionEvent->getParam(self::EVENT_PARAM_MESSAGE_HANDLER) === null) {
                    throw new RuntimeException(sprintf(
                        'QueryBus was not able to identify a Finder for query %s',
                        $this->getMessageName($actionEvent->getParam(self::EVENT_PARAM_MESSAGE))
                    ));
                }
            },
            self::PRIORITY_LOCATE_HANDLER
        );
    }

    /**
     * @param mixed $query
     *
     * @return mixed
     *
     * @throws RuntimeException
     */
    public function dispatch($query)
    {
        $actionEventEmitter = $this->events;
        $actionEvent        = $actionEventEmitter->getNewActionEvent(
            self::EVENT_DISPATCH,
            $this,
            [
                self::EVENT_PARAM_MESSAGE => $query,
            ]
        );

        try {
            $actionEventEmitter->dispatch($actionEvent);
            if (!$actionEvent->getParam(self::EVENT_PARAM_MESSAGE_HANDLED)) {
                throw new RuntimeException(sprintf('Query %s was not handled', $this->getMessageName($query)));
            }
        } catch (\Throwable $exception) {
            $actionEvent->setParam(self::EVENT_PARAM_EXCEPTION, $exception);
        } finally {
            $this->triggerFinalize($actionEvent);
        }

        return $actionEvent->getParam(self::EVENT_PARAM_RESULT);
    }
}
