<?php
namespace Droid\Test\Plugin\Os\Command;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

use Droid\Plugin\Os\Command\OsRebootCommand;

class OsRebootCommandTest extends PHPUnit_Framework_TestCase
{
    protected $app;
    protected $process;
    protected $processBuilder;

    protected function setUp()
    {
        $this->process = $this
            ->getMockBuilder(Process::class)
            ->disableOriginalConstructor()
            ->setMethods(array('run', 'getErrorOutput', 'getExitCode'))
            ->getMock()
        ;
        $this->processBuilder = $this
            ->getMockBuilder(ProcessBuilder::class)
            ->setMethods(array('setArguments', 'getProcess'))
            ->getMock()
        ;

        $command = new OsRebootCommand; #($this->processBuilder);

        $this->app = new Application;
        $this->app->add($command);
    }

    public function testReboot()
    {
        $this->markTestIncomplete('This test has not been written.');
    }
}
