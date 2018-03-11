<?php

declare(strict_types=1);

namespace GrahamCampbell\GitHubNotifications;

use Github\Client;
use Github\HttpClient\Builder;
use Http\Client\Common\Plugin\RetryPlugin;

class ClientFactory
{
    /**
     * Make a new github notifications nclient.
     *
     * @param string $token
     *
     * @return \Github\Client
     */
    public static function make(string $token)
    {
        $builder = new Builder();

        $builder->addPlugin(new RetryPlugin(['retries' => 2]));

        $client = new Client($builder);

        $client->authenticate($token, 'http_token');

        return $client;
    }
}
