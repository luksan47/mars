<?php

namespace App\Console;

use Illuminate\Support\Facades\Log;

/**
 * Collection of exec commands.
 * The commands return values accordingly in deug mode as well.
 */
class Commands
{
    private static function isDebugMode()
    {
        return config('app.debug');
    }

    public static function updateCompletedPrintingJobs()
    {
        if (self::isDebugMode()) {
            $result = [0];
        } else {
            $result = [];
            exec("lpstat -W completed -o " . config('print.printer_name') . " | awk '{print $1}'", $result);
        }
        return $result;
    }

    public static function print($command)
    {
        if (self::isDebugMode()) {
            $job_id = 0;
            $result = "request id is " . config('print.printer_name') . "-" . $job_id . " (1 file(s))";
        } else {
            Log::info($command);
            $result = exec($command);
        }
        return $result;
    }

    public static function cancelPrintJob(string $jobID)
    {
        if (self::isDebugMode()) {
            // cancel(1) exits with status code 0 if it succeeds
            $result = ['output' => '', 'exit_code' => 0];
        } else {
            $command = "cancel " . $jobID;
            Log::info($command);
            $output = exec($command, $result, $exit_code);
            $result = ['output' => $output, 'exit_code' => $exit_code];
        }
        return $result;
    }

    public static function getPages($path)
    {
        if (self::isDebugMode()) {
            $result = rand(1, 10);
        } else {
            $command = "pdfinfo " . $path . " | grep '^Pages' | awk '{print $2}' 2>&1";
            Log::info($command);
            $result = exec($command);
        }
        return $result;
    }

    public static function pingRouter($router)
    {
        if (self::isDebugMode()) {
            $result = rand(1, 10) > 9 ? "error" : '';
        } else {
            // This happens too often to log.
            $command = "ping " . $router->ip . " -c 1 | grep 'error\|unreachable'";
            $result = exec($command);
        }
        return $result;
    }

    public static function latexToPdf($path, $outputDir)
    {
        if (self::isDebugMode()) {
            $result = "ok";
        } else {
            $command = "pdflatex " . "-interaction=nonstopmode -output-dir " . $outputDir . " " . $path . " 2>&1";
            Log::info($command);
            $result = exec($command);
        }
        return $result;
    }
}
