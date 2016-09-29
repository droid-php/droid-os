<?php

namespace Droid\Plugin\Os\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;

class OsRebootCommand extends Command
{
    private $processBuilder;

    public function __construct(ProcessBuilder $builder, $name = null)
    {
        $this->processBuilder = $builder;
        return parent::__construct($name);
    }

    public function configure()
    {
        $this
            ->setName('os:reboot')
            ->setDescription('Initiate a reboot.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $p = $this->getProcess(array('shutdown', '-r', 'now', '&&', 'logout'));

        $output->writeln('<info>I attempt to initiate a reboot.</info>');
        if ($p->run()) {
            $output->writeln(
                sprintf(
                    '<error>I have failed to initiate a reboot. Code %d: %s</error>',
                    $p->getExitCode(),
                    $p->getErrorOutput()
                )
            );
            return $p->getExitCode();
        }
        $output->writeln('<info>I have successfully initiated a reboot.</info>');
    }

    /**
     * @return \Symfony\Component\Process\Process
     */
    private function getProcess($arguments)
    {
        return $this
            ->processBuilder
            ->setArguments($arguments)
            ->setTimeout(0.0)
            ->getProcess()
        ;
    }
}
