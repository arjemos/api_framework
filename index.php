<?php
	include 'autoload.php';
	//BASIC LOGGER
	//$log = new Monolog\Logger('name');
	//$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
	//$log->addWarning('Foo');
	//
	//ROLLAR LOGGER
	//use \Rollbar\Rollbar;
	//use \Rollbar\Payload\Level;
	//Rollbar::init(
	//   array(
	//        'access_token' => '5862ef46e5674c5d9d36b369d93c759d',
	//        'environment' => 'production'
	//    )
	//);

	//Rollbar::log(Level::info(), 'Test info message');
	//Rollbar::log(Level::warning(), 'Test warning message');
	//Rollbar::log(Level::debug(), 'Test debug message');
	//Rollbar::log(Level::critical(), 'Test critical message');
	//Rollbar::log(Level::error(), 'Test error message');
	//throw new \Exception('Test exception');
	//END LOGGER ROLLAR
	//STACKIFY LOGGER
		////use Monolog\Logger;
		////use Monolog\Handler\StreamHandler;	//Prueba 1
		////use Monolog\Handler\FirePHPHandler; //Prueba 2
		////use Monolog\Handler\SwiftMailerHandler; //Prueba 3
		//use Monolog\Handler\Swift_SmtpTransport; //Prueba 3

		//$logger = new Monolog\Logger('channel-name');
		//$app->container->logger = $logger;

		//PRUEBA 0
		//$logger = new Monolog\Logger('channel-name');
		//$logger->pushHandler(new StreamHandler('app.log', Logger::DEBUG));
		//PRUEBA 1
		//$logger->info('This is a log! ^_^ ');
		//$logger->warning('This is a log warning! ^_^ ');
		//$logger->error('This is a log error! ^_^ ');
		//PRUEBA 2
		//$logger->pushHandler(new FirePHPHandler());
		//$logger->error('Logger is now Ready');
		//PRUEBA 3 CORREO
		// Create the Transport
		/*
		$transporter = new Swift_SmtpTransport('smtp.example.com', 465, 'ssl');
		$transporter->setUsername('user@example.com');
		$transporter->setPassword('123456');

		// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transporter);

		// Create a message
		$message = (new Swift_Message('A CRITICAL log was added'));
		$message->setFrom(['example-FROM@example.com' => 'Someone FROM']);
		$message->setTo(['someone-TO@example.com' => 'SomeoneTO']);

		$logger = new Logger('default');
		$logger->pushHandler(new StreamHandler(DIR.'/test.log', Logger::INFO));
		$logger->pushHandler(new SwiftMailerHandler($mailer, $message, Logger::CRITICAL, false));
		$logger->addCritical('Hey, a critical log entry!');
		*/
	//END STACKIFY LOGGER
	$router = new \Core\Routing\Router($_SERVER['REQUEST_URI']);
	$router->run();
?>

