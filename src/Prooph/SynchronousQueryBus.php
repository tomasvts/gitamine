<?php
declare(strict_types=1);

namespace App\Prooph;

use Prooph\Bundle\ServiceBus\NamedMessageBus;
use Prooph\Bundle\ServiceBus\NamedMessageBusTrait;
use Prooph\Common\Event\ActionEvent;
use Prooph\Common\Event\ActionEventEmitter;
use Prooph\Common\Event\ProophActionEventEmitter;
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

    /** @noinspection MagicMethodsValidityInspection */
    /** @noinspection PhpMissingParentConstructorInspection */

    /**
     * SynchronousQueryBus constructor.
     *
     * @param null|ActionEventEmitter $actionEventEmitter
     */
    public function __construct(?ActionEventEmitter $actionEventEmitter = null)
    {
        if (null === $actionEventEmitter) {
            $actionEventEmitter = new ProophActionEventEmitter([
                self::EVENT_DISPATCH,
                self::EVENT_FINALIZE
            ]);
        }

        $actionEventEmitter->attachListener(
            self::EVENT_DISPATCH,
            function (ActionEvent $actionEvent): void {
                $actionEvent->setParam(self::EVENT_PARAM_MESSAGE_HANDLED, false);
                $message = $actionEvent->getParam(self::EVENT_PARAM_MESSAGE);

                if ($message instanceof HasMessageName) {
                    $actionEvent->setParam(self::EVENT_PARAM_MESSAGE_NAME, $message->messageName());
                }
            },
            self::PRIORITY_INITIALIZE
        );

        $actionEventEmitter->attachListener(
            self::EVENT_DISPATCH,
            function (ActionEvent $actionEvent): void {
                if ($actionEvent->getParam(self::EVENT_PARAM_MESSAGE_NAME) === null) {
                    $actionEvent->setParam(
                        self::EVENT_PARAM_MESSAGE_NAME,
                        $this->getMessageName($actionEvent->getParam(self::EVENT_PARAM_MESSAGE))
                    );
                }
            },
            self::PRIORITY_DETECT_MESSAGE_NAME
        );

        $actionEventEmitter->attachListener(
            self::EVENT_FINALIZE,
            function (ActionEvent $actionEvent): void {
                $exception = $actionEvent->getParam(self::EVENT_PARAM_EXCEPTION);
                if ($exception) {
                    throw $exception;
                }
            }
        );

        $this->events = $actionEventEmitter;

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
                self::EVENT_PARAM_MESSAGE => $query
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

    /**
     * @return string
     */
    public function busType(): string
    {
        return 'synchronous-bus';
    }

    /**
     * @return string
     */
    public function busName(): string
    {
        return 'synchronous-bus';
    }
}
