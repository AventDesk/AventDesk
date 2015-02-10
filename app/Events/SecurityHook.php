<?php


namespace Avent\Events;

use Avent\Core\Event\Abstraction\SecurityEventAbstract;
use Avent\Repository\ApiKeyRepository;
use Avent\Services\Application\JwtService;
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
     * @var JwtService
     */
    protected $jwt;

    /**
     * @param Logger $logger
     * @param JwtService $jwt
     */
    public function __construct(Logger $logger, JwtService $jwt = null)
    {
        parent::__construct($logger);
        $this->jwt = $jwt;
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

                $key = $this->jwt->decode($request["token"]);

                if ((!($key->level >= $rule[3])) || is_null($key)) {
                    $event->stopPropagation();
                }
            }
        }
    }
}

// EOF
