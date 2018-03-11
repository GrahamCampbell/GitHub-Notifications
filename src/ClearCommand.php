<?php

declare(strict_types=1);

namespace GrahamCampbell\GitHubNotifications;

use Github\ResultPager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends Command
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
            ->addArgument('org', InputArgument::REQUIRED)
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
        $org = $input->getArgument('org');
        $c = ClientFactory::make($this->resolveToken($input));
        $n = $c->notifications();

        foreach ((new ResultPager($c))->fetchAll($n, 'all') as $notification) {
            if (explode('/', $notification['repository']['full_name'])[0] === $org && $notification['subject']['type'] === 'Issue') {
                $marked++;
                $n->markThreadRead($notification['id']);
            }
        }

        $output->writeln("<comment>Marked {$marked} issue notifications as read.</comment>");
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
        $token = $input->getOption('token') ?: getenv('GITHUB_TOKEN');

        if (!$token) {
            throw new InvalidOptionException('Unable to resolve the token to use.');
        }

        return $token;
    }
}
