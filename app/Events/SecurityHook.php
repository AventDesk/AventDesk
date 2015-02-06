<?php


namespace Avent\Events;

use Avent\Core\Event\Abstraction\SecurityEventAbstract;
use Avent\Repository\ApiKeyRepository;
use FastRoute\Dispatcher;
use League\Event\EventInterface;
use Monolog\Logger;

/**
 * Class SecurityHook
 * @package Avent\Events
 */
class SecurityHook extends SecurityEventAbstract
{
    /**
     * @var ApiKeyRepository
     */
    protected $repository;

    /**
     * @param Logger $logger
     * @param ApiKeyRepository $repository
     */
    public function __construct(Logger $logger, ApiKeyRepository $repository = null)
    {
        parent::__construct($logger);
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(EventInterface $event, $request = [], $acl = [])
    {
        $request_uri = $request["request_uri"];
        $request_method = $request["method"];

        foreach ($acl as $rule) {
            if ($request_uri == $rule[1] && $request_method == $rule[0]) {
                // No authorization required
                if ($rule[3] == 0) {
                    return;
                }

                $key = $this->repository->findOneBy(["api_key" => $request["api_key"]]);

                if ((!($key->getLevel() >= $rule[3])) || is_null($key)) {
                    $event->stopPropagation();
                }
            }
        }
    }
}

// EOF
