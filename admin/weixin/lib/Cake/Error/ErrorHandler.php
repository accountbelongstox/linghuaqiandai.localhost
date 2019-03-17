<?php
/**
 * ErrorHandler class
 *
 * Provides Error Capturing for Framework errors.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Error
 * @since         CakePHP(tm) v 0.10.5.1732
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Debugger', 'Utility');
App::uses('CakeLog', 'Log');
App::uses('ExceptionRenderer', 'Error');
App::uses('Router', 'Routing');

class ErrorHandler {

	public static function handleException(Exception $exception) {
		$config = Configure::read('Exception');
		self::_log($exception, $config);

		$renderer = isset($config['renderer']) ? $config['renderer'] : 'ExceptionRenderer';
		if ($renderer !== 'ExceptionRenderer') {
			list($plugin, $renderer) = pluginSplit($renderer, true);
			App::uses($renderer, $plugin . 'Error');
		}
		try {
			$error = new $renderer($exception);
			$error->render();
		} catch (Exception $e) {
			set_error_handler(Configure::read('Error.handler')); // Should be using configured ErrorHandler
			Configure::write('Error.trace', false); // trace is useless here since it's internal
			$message = sprintf("[%s] %s\n%s", // Keeping same message format
				get_class($e),
				$e->getMessage(),
				$e->getTraceAsString()
			);
			trigger_error($message, E_USER_ERROR);
		}
	}

/**
 * Generates a formatted error message
 * @param Exception $exception Exception instance
 * @return string Formatted message
 */
	protected static function _getMessage($exception) {
		$message = sprintf("[%s] %s",
			get_class($exception),
			$exception->getMessage()
		);
		if (method_exists($exception, 'getAttributes')) {
			$attributes = $exception->getAttributes();
			if ($attributes) {
				$message .= "\nException Attributes: " . var_export($exception->getAttributes(), true);
			}
		}
		if (php_sapi_name() !== 'cli') {
			$request = Router::getRequest();
			if ($request) {
				$message .= "\nRequest URL: " . $request->here();
			}
		}
		$message .= "\nStack Trace:\n" . $exception->getTraceAsString();
		return $message;
	}

/**
 * Handles exception logging
 *
 * @param Exception $exception
 * @param array $config
 * @return boolean
 */
	protected static function _log(Exception $exception, $config) {
		if (empty($config['log'])) {
			return false;
		}

		if (!empty($config['skipLog'])) {
			foreach ((array)$config['skipLog'] as $class) {
				if ($exception instanceof $class) {
					return false;
				}
			}
		}
		return CakeLog::write(LOG_ERR, self::_getMessage($exception));
	}

/**
 * Set as the default error handler by CakePHP. Use Configure::write('Error.handler', $callback), to use your own
 * error handling methods. This function will use Debugger to display errors when debug > 0. And
 * will log errors to CakeLog, when debug == 0.
 *
 * You can use Configure::write('Error.level', $value); to set what type of errors will be handled here.
 * Stack traces for errors can be enabled with Configure::write('Error.trace', true);
 *
 * @param integer $code Code of error
 * @param string $description Error description
 * @param string $file File on which error occurred
 * @param integer $line Line that triggered the error
 * @param array $context Context
 * @return boolean true if error was handled
 */
	public static function handleError($code, $description, $file = null, $line = null, $context = null) {
		if (error_reporting() === 0) {
			return false;
		}
		$errorConfig = Configure::read('Error');
		list($error, $log) = self::mapErrorCode($code);
		if ($log === LOG_ERR) {
			return self::handleFatalError($code, $description, $file, $line);
		}

		$debug = Configure::read('debug');
		if ($debug) {
			$data = array(
				'level' => $log,
				'code' => $code,
				'error' => $error,
				'description' => $description,
				'file' => $file,
				'line' => $line,
				'context' => $context,
				'start' => 2,
				'path' => Debugger::trimPath($file)
			);
			return Debugger::getInstance()->outputError($data);
		}
		$message = $error . ' (' . $code . '): ' . $description . ' in [' . $file . ', line ' . $line . ']';
		if (!empty($errorConfig['trace'])) {
			$trace = Debugger::trace(array('start' => 1, 'format' => 'log'));
			$message .= "\nTrace:\n" . $trace . "\n";
		}
		return CakeLog::write($log, $message);
	}

/**
 * Generate an error page when some fatal error happens.
 *
 * @param integer $code Code of error
 * @param string $description Error description
 * @param string $file File on which error occurred
 * @param integer $line Line that triggered the error
 * @return boolean
 */
	public static function handleFatalError($code, $description, $file, $line) {
		$logMessage = 'Fatal Error (' . $code . '): ' . $description . ' in [' . $file . ', line ' . $line . ']';
		CakeLog::write(LOG_ERR, $logMessage);

		$exceptionHandler = Configure::read('Exception.handler');
		if (!is_callable($exceptionHandler)) {
			return false;
		}

		if (ob_get_level()) {
			ob_end_clean();
		}

		if (Configure::read('debug')) {
			call_user_func($exceptionHandler, new FatalErrorException($description, 500, $file, $line));
		} else {
			call_user_func($exceptionHandler, new InternalErrorException());
		}
		return false;
	}

/**
 * Map an error code into an Error word, and log location.
 *
 * @param integer $code Error code to map
 * @return array Array of error word, and log location.
 */
	public static function mapErrorCode($code) {
		$error = $log = null;
		switch ($code) {
			case E_PARSE:
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				$error = 'Fatal Error';
				$log = LOG_ERR;
				break;
			case E_WARNING:
			case E_USER_WARNING:
			case E_COMPILE_WARNING:
			case E_RECOVERABLE_ERROR:
				$error = 'Warning';
				$log = LOG_WARNING;
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = 'Notice';
				$log = LOG_NOTICE;
				break;
			case E_STRICT:
				$error = 'Strict';
				$log = LOG_NOTICE;
				break;
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				$error = 'Deprecated';
				$log = LOG_NOTICE;
				break;
		}
		return array($error, $log);
	}

}
