<?php
declare(strict_types=1);

namespace Gitamine\Domain;

use Gitamine\Exception\InvalidEventException;

/**
 * Class Event
 * @package Gitamine\Domain
 */
class Event
{
    public const APPLYPATCH_MSG     = 'applypatch-msg';
    public const COMMIT_MSG         = 'commit-msg';
    public const POST_APPLYPATCH    = 'post-applypatch';
    public const POST_CHECKOUT      = 'post-checkout';
    public const POST_COMMIT        = 'pre-commit';
    public const POST_MERGE         = 'post-merge';
    public const POST_RECEIVE       = 'post-receive';
    public const POST_REWRITE       = 'post-rewrite';
    public const POST_UPDATE        = 'post-update';
    public const PRE_APPLYPATCH     = 'pre-applypatch';
    public const PRE_AUTO_GC        = 'pre-auto-gc';
    public const PRE_COMMIT         = 'pre-commit';
    public const PRE_PUSH           = 'pre-push';
    public const PRE_REBASE         = 'pre-rebase';
    public const PRE_RECEIVE        = 'pre-receive';
    public const PREPARE_COMMIT_MSG = 'prepare-commit-msg';
    public const UPDATE             = 'update';

    public const VALID_EVENTS = [
        self::APPLYPATCH_MSG,
        self::COMMIT_MSG,
        self::POST_APPLYPATCH,
        self::POST_CHECKOUT,
        self::POST_COMMIT,
        self::POST_MERGE,
        self::POST_RECEIVE,
        self::POST_REWRITE,
        self::POST_UPDATE,
        self::PRE_APPLYPATCH,
        self::PRE_AUTO_GC,
        self::PRE_COMMIT,
        self::PRE_PUSH,
        self::PRE_REBASE,
        self::PRE_RECEIVE,
        self::PREPARE_COMMIT_MSG,
        self::UPDATE
    ];

    /**
     * @var string
     */
    private $event;

    /**
     * Event constructor.
     *
     * @param string $event
     */
    public function __construct(string $event)
    {
        if (!in_array($event, self::VALID_EVENTS, true)) {
            throw new InvalidEventException($event);
        }
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function event(): string
    {
        return $this->event;
    }
}
