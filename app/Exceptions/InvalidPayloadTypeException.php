<?php

namespace App\Exceptions;
use Exception;

class InvalidPayloadTypeException extends Exception
{
	/**
	 * Constructs a new InvalidPayloadTypeException instance.
	 *
	 * @param string $message Optional message for the exception
	 */
	public function __construct($message="") {
		if(!empty($message)) {
			// add a leading space if there is something in the parameter
			$message = " {$message}";
		}
		parent::__construct("This only accepts payloads as JSON." . $message);
	}
}