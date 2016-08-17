<?php

namespace Droid\Plugin\Os;

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
            new OsRebootCommand,
        );
    }
}
