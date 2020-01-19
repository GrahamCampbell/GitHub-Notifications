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

namespace GrahamCampbell\GitHubNotifications\Console\Commands;

use Github\Client;
use Github\ResultPager;
use GrahamCampbell\GitHubNotifications\ClientFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ClearCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('clear')
            ->setDescription('Clear all issue notifications for a given organization')
            ->addArgument('orgs', InputArgument::IS_ARRAY, 'Specifies which organizations to clear.')
            ->addOption('token', null, InputOption::VALUE_OPTIONAL, 'Specifies the token to use.');
    }

    /**
     * Execute the command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $marked = 0;
        $orgs = static::resolveOrgs($input);
        $c = ClientFactory::make(static::resolveToken($input));
        $n = $c->notification();

        foreach ((new ResultPager($c))->fetchAll($n, 'all') as $notification) {
            if (static::shouldMarkAsRead($c, $orgs, $notification)) {
                $marked++;
                $n->markThreadRead($notification['id']);
            }
        }

        $output->writeln("<comment>Marked {$marked} issue notifications as read.</comment>");
    }

    /**
     * Resolve the organizations to clear.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @throws \Symfony\Component\Console\Exception\InvalidOptionException
     *
     * @return string[]
     */
    protected static function resolveOrgs(InputInterface $input)
    {
        $orgs = $input->getArgument('orgs');

        if (!$orgs) {
            throw new InvalidOptionException('Please provide at least one organization.');
        }

        return (array) $orgs;
    }

    /**
     * Resolve the token to use.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @throws \Symfony\Component\Console\Exception\InvalidOptionException
     *
     * @return string
     */
    protected static function resolveToken(InputInterface $input)
    {
        $token = $input->getOption('token') ?: ($_SERVER['GITHUB_TOKEN'] ?? null);

        if (!$token) {
            throw new InvalidOptionException('Unable to resolve the token to use.');
        }

        return (string) $token;
    }

    /**
     * Should the notification be marked as read?
     *
     * @param \Github\Client $c
     * @param string[]       $orgs
     * @param array          $notification
     *
     * @return bool
     */
    protected static function shouldMarkAsRead(Client $c, array $orgs, array $notification)
    {
        if (!in_array(explode('/', $notification['repository']['full_name'])[0], $orgs, true)) {
            return false;
        }

        // don't care about any issues
        if ($notification['subject']['type'] === 'Issue') {
            return true;
        }

        // don't care about rejected PRs
        if ($notification['subject']['type'] === 'PullRequest') {
            $pr = $c->pr()->show(...static::extractPullRequestData($notification));
            if ($pr['state'] !== 'open' && !$pr['merged']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract the PR data from a PR notification.
     *
     * @param array $notification
     *
     * @return array
     */
    protected static function extractPullRequestData(array $notification)
    {
        $args = explode('/', $notification['repository']['full_name']);
        $data = explode('/', $notification['subject']['url']);

        return [$args[0], $args[1], (int) end($data)];
    }
}
