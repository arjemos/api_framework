<?php 
	require __DIR__.'/vendor/autoload.php';
	require 'Config/app.php';
	
	spl_autoload_register(function ($class) {
	   	require_once( str_replace('\\', '/', $class . '.php') );
	});

	set_error_handler(function($errno, $errstr, $errfile, $errline ){
	    //throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
	    $log = new Monolog\Logger('name');
		$log->pushHandler(new Monolog\Handler\StreamHandler('Storage/logs/app.log', Monolog\Logger::DEBUG));
		switch ($errno){
	        case E_ERROR: // 1 //
	            $typestr = 'E_ERROR'; break;
	        case E_WARNING: // 2 //
	            $typestr = 'E_WARNING'; break;
	        case E_PARSE: // 4 //
	            $typestr = 'E_PARSE'; break;
	        case E_NOTICE: // 8 //
	            $typestr = 'E_NOTICE'; break;
	        case E_CORE_ERROR: // 16 //
	            $typestr = 'E_CORE_ERROR'; break;
	        case E_CORE_WARNING: // 32 //
	            $typestr = 'E_CORE_WARNING'; break;
	        case E_COMPILE_ERROR: // 64 //
	            $typestr = 'E_COMPILE_ERROR'; break;
	        case E_CORE_WARNING: // 128 //
	            $typestr = 'E_COMPILE_WARNING'; break;
	        case E_USER_ERROR: // 256 //
	            $typestr = 'E_USER_ERROR'; break;
	        case E_USER_WARNING: // 512 //
	            $typestr = 'E_USER_WARNING'; break;
	        case E_USER_NOTICE: // 1024 //
	            $typestr = 'E_USER_NOTICE'; break;
	        case E_STRICT: // 2048 //
	            $typestr = 'E_STRICT'; break;
	        case E_RECOVERABLE_ERROR: // 4096 //
	            $typestr = 'E_RECOVERABLE_ERROR'; break;
	        case E_DEPRECATED: // 8192 //
	            $typestr = 'E_DEPRECATED'; break;
	        case E_USER_DEPRECATED: // 16384 //
	            $typestr = 'E_USER_DEPRECATED'; break;
	    }
	    $log->addDebug($errstr, ["error"=>$typestr]);
	    echo "<br>Codigo: ";
	    print_r($errno);
	    echo "<br>Error: ";
	    print_r($errstr);
	    echo "<br>Archivo: ";
	    print_r($errfile);
	    echo "<br>Linea: ";
	    print_r($errline);
	    echo "<br>";
	});
?>