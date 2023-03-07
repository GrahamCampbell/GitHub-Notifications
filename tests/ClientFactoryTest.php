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

namespace GrahamCampbell\Tests\GitHubNotifications;

use Github\Client;
use GrahamCampbell\GitHubNotifications\ClientFactory;
use PHPUnit\Framework\TestCase;
use TypeError;

class ClientFactoryTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        self::assertInstanceOf(Client::class, ClientFactory::make('qwertyuiop'));
    }

    public function testInstantiationRequiresParam()
    {
        $this->expectException(TypeError::class);

        ClientFactory::make();
    }
}
