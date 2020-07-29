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

namespace GrahamCampbell\GitHubNotifications\Console;

use GrahamCampbell\GitHubNotifications\Console\Commands\ClearCommand;
use Symfony\Component\Console\Application as SymfonyApplication;

final class Application extends SymfonyApplication
{
    /**
     * The application name.
     *
     * @var string
     */
    const APP_NAME = 'GitHub Notifications';

    /**
     * The application version.
     *
     * @var string
     */
    const APP_VERSION = '2.0.8';

    /**
     * Create a new StyleCI CLI application.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(self::APP_NAME, self::APP_VERSION);
        $this->add(new ClearCommand());
    }
}
