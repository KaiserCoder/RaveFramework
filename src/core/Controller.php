<?php

namespace rave\core;

use rave\core\exception\IOException;

abstract class Controller
{
    const LOG_NOTICE = 0;
    const LOG_WARNING = 1;
    const LOG_FATAL_ERROR = 2;

    protected $data = [];

    protected $layout = null;

    private static $currentLogFile;

    protected function loadView(string $view, array $data = [])
    {
        if (!empty($data) || !empty($this->data)) {
            extract(array_merge($this->data, $data));
        }

        $controller = explode('\\', static::class);

        $file = SRC . '/app/view/' . strtolower(end($controller)) . '/' . $view . '.php';

        ob_start();

        if (file_exists($file)) {
            include_once $file;
        } else {
            Error::create('Error while loading view', 404);
        }

        $content = ob_get_clean();

        if (!$this->layout) {
            echo $content;
        } else {
            include_once SRC . '/app/view/layout/' . $this->layout . '.php';
        }
    }

    protected function setLayout($layout, array $data = [])
    {
        $this->data = array_merge($this->data, $data);
        $this->layout = file_exists(SRC . '/app/view/layout/' . $layout . '.php') ? $layout : null;
    }

    protected function redirect(string $page = '')
    {
    	header('Location: ' . WEB_ROOT . '/' . $page);
        exit;
    }
    
    protected function log(string $message, int $priority = self::LOG_NOTICE)
    {
    	$log = date('H:i:s');

        switch ($priority) {
            case self::LOG_NOTICE:
                $log .= ' : ';
                break;
            case self::LOG_WARNING:
                $log .= ' WARNING : ';
                break;
            case self::LOG_FATAL_ERROR:
                $log .= ' FATAL ERROR : ';
                break;
            default:
                $log .= ' : ';
        }

        $log .= $message;

        try {
            $this->writeLog($log);
        } catch (IOException $ioException) {
            Error::create($ioException->getMessage(), 500);
        }
    }

    private function writeLog(string $message)
    {
    	if (isset(self::$currentLogFile)) {
    		file_put_contents(self::$currentLogFile, $message . PHP_EOL, FILE_APPEND);
    	} else {
            if (file_exists(ROOT . '/log') === false) {
            	mkdir(ROOT . '/log');
            }
    		
            self::$currentLogFile = ROOT . '/log/' . date('d-m-Y') . '.log';

            if (!file_exists(self::$currentLogFile) && !fopen(self::$currentLogFile, 'a')) {
                throw new IOException('Unable to create log file');
            }

            $this->writeLog($message);
        }
    }

}