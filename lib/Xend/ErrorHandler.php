<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/26
 * Time: 18:05
 */

namespace Xend;

class ErrorHandler
{
    const E_FATAL = E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR;

    public function initHandlers()
    {
        // disable errors
        ini_set('display_errors', 'off');

        set_exception_handler(array($this, 'exception'));
        set_error_handler(array($this, 'error'));

        register_shutdown_function(array($this, 'fatalError'));
    }

    public function exception(\Exception $exception)
    {
        $this->endRequest($exception->getMessage());
    }

    public function error($errorCode, $message)
    {
        $this->endRequest($message);
    }
    
    public function fatalError()
    {
        $error = error_get_last();

        if($error && $error['type'] & self::E_FATAL)
        {
            $this->endRequest($error['message']);
        }
    }

    private function endRequest($message, $code = 500)
    {
        Application::getInstant()->response->setResponse('服务器出现错误：'.$message, $code)->sendResponse();
        exit;
    }
}