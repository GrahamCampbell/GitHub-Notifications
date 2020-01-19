<?php

declare(strict_types=1);

/*
 * This file is part of GitHub Notifications.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHubNotifications;

use GrahamCampbell\GitHubNotifications\Console\Application;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application as SymfonyApplication;

class ApplicationTest extends TestCase
{
    public function testCreateApplication()
    {
        $app = new Application();

        $this->assertInstanceOf(SymfonyApplication::class, $app);
        $this->assertSame('GitHub Notifications', $app->getName());
    }
}
