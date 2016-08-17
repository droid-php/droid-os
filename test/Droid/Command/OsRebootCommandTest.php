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
    protected $tester;

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

        $command = new OsRebootCommand($this->processBuilder);

        $this->app = new Application;
        $this->app->add($command);

        $this->tester = new CommandTester($command);
    }

    public function testRebootWillFail()
    {
        $this
            ->processBuilder
            ->expects($this->once())
            ->method('setArguments')
            ->with(array('shutdown', '-r', 'now', '&&', 'logout'))
            ->willReturnSelf()
        ;
        $this
            ->processBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->willReturn($this->process)
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('run')
            ->willReturn(1)
        ;
        $this
            ->process
            ->expects($this->atLeastOnce())
            ->method('getExitCode')
            ->willReturn(1)
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('getErrorOutput')
            ->willReturn('something went awry')
        ;

        $this->tester->execute(
            array('command' => $this->app->find('os:reboot'))
        );

        $this->assertRegExp(
            '/I have failed to initiate a reboot\. Code 1: something went awry/',
            $this->tester->getDisplay()
        );
    }

    public function testRebootWillSucceed()
    {
        $this
            ->processBuilder
            ->expects($this->once())
            ->method('setArguments')
            ->with(array('shutdown', '-r', 'now', '&&', 'logout'))
            ->willReturnSelf()
        ;
        $this
            ->processBuilder
            ->expects($this->once())
            ->method('getProcess')
            ->willReturn($this->process)
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('run')
            ->willReturn(0)
        ;
        $this
            ->process
            ->expects($this->never())
            ->method('getExitCode')
        ;
        $this
            ->process
            ->expects($this->never())
            ->method('getErrorOutput')
        ;

        $this->tester->execute(
            array('command' => $this->app->find('os:reboot'))
        );

        $this->assertRegExp(
            '/I have successfully initiated a reboot/',
            $this->tester->getDisplay()
        );
    }
}
