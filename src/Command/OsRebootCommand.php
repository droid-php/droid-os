<?php

namespace Droid\Plugin\Os\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OsRebootCommand extends Command
{
    public function configure()
    {
        $this->setName('os:reboot');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
