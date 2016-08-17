<?php

namespace Droid\Plugin\Os;

use Symfony\Component\Process\ProcessBuilder;

use Droid\Plugin\Os\Command\OsRebootCommand;

class DroidPlugin
{
    public function __construct($droid)
    {
        $this->droid = $droid;
    }

    public function getCommands()
    {
        return array(
            new OsRebootCommand(new ProcessBuilder),
        );
    }
}
