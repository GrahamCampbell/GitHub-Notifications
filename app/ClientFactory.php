<?php

declare(strict_types=1);

/*
 * This file is part of GitHub Notifications.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\GitHubNotifications;

use Github\Client;
use Github\HttpClient\Builder;
use Http\Client\Common\Plugin\RetryPlugin;

final class ClientFactory
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

        $client->authenticate($token, Client::AUTH_ACCESS_TOKEN);

        return $client;
    }
}
