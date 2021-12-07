<?php

namespace App\Library\Mw;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

class Log
{
    const LOG_EMERGENCY = 'emergency';
    const LOG_ALERT = 'alert';
    const LOG_CRITICAL = 'critical';
    const LOG_ERROR = 'error';
    const LOG_WARNING = 'warning';
    const LOG_NOTICE = 'notice';
    const LOG_INFO = 'info';
    const LOG_DEBUG = 'debug';

    private static $_logger = null;

    public static function createdFileLog() {
        $date_format = array(
            '[YYYY]'=> date('Y'),
            '[MM]' => date('m'),
            '[N]' => self::getWeeks(),
        );

        $filename = strtr(APP_LOG_FILE, $date_format);

        if (!file_exists(storage_path().'/logs/'. $filename)) {
            $fs = new Filesystem();
            $fs->put(storage_path().'/logs/'. $filename, '', true);
            $fs->chmod(storage_path().'/logs/'. $filename, '0750');
        }

        return $filename;
    }

    public static function init($path, $filename, $level)
    {

    }

    public static function debug($msg)
    {
        $fileName = self::createdFileLog();
        self::write($fileName, debug_backtrace(), $msg, self::LOG_DEBUG);
    }

    public static function info($msg)
    {
        $fileName = self::createdFileLog();
        self::write($fileName, debug_backtrace(), $msg, self::LOG_INFO);
    }

    public static function error($msg)
    {
        if (is_object($msg) && ($msg instanceof Exception)) {
            $msg = $msg->getMessage() . PHP_EOL . $msg->getTraceAsString();
        }
        $fileName = self::createdFileLog();
        self::write($fileName, debug_backtrace(), $msg, self::LOG_ERROR);
    }

    private static function write($fileName, $backtraces, $msg, $level)
    {
        $ipAddress = request()->getClientIp();
        $output  = '['. $ipAddress. '] ';
        $output .= $backtraces[1]['class'].".".$backtraces[1]['function'].
            " (".$backtraces[0]['line'].") ";
        $output .= $msg;
        $output = mb_convert_encoding($output, 'UTF-8', 'auto');

        $orderLog = new Logger($level);
        $orderLog->pushHandler(new StreamHandler(storage_path('logs/' . $fileName)), Logger::INFO);
        $orderLog->$level($level, [$output]);
    }

    private static function getWeeks()
    {
        $timestamp = time();
        $maxday    = date("t",$timestamp);
        $thismonth = getdate($timestamp);
        $timeStamp = mktime(0,0,0,$thismonth['mon'],1,$thismonth['year']);
        $startday  = date('w',$timeStamp);
        $day = $thismonth['mday'];
        $weeks = 0;
        $week_num = 0;

        for ($i=0; $i<($maxday+$startday); $i++) {
            if(($i % 7) == 0){
                $weeks++;
            }

            if($day == ($i - $startday + 1)){
                $week_num = $weeks;
            }
        }

        return $week_num;
    }
}
