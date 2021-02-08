<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        //
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        if ($this->consoleRoutesExist()) {
            $this->requireConsoleRoutes();
        }
    }

    protected function consoleRoutesPath(): string
    {
        return base_path('routes/console.php');
    }

    protected function requireConsoleRoutes()
    {
        require $this->consoleRoutesPath();
    }

    protected function consoleRoutesExist(): bool
    {
        return file_exists($this->consoleRoutesPath());
    }
}
