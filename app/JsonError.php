<?php
namespace ExpoHub;

class JsonError 
{
	public $title;
	public $detail;
	public $status;
	public $code;

	/**
	 * Constructor
	 * 
	 * @param string $title  The error's title property
	 * @param string $detail The error's detail property
	 * @param string $status The error's status property
	 * @param string $code   The error's code property
	 */
	public function __construct($title, $detail, $status, $code) 
	{
		$this->title 	= $title;
		$this->detail 	= $detail;
		$this->status 	= $status;
		$this->code 	= $code;
	}

	/**
	 * Converts to array representation
	 * 
	 * @return array the array representation
	 */
	public function toArray() {
		return [
			'title' 	=> $this->title,
			'detail' 	=> $this->detail,
			'status' 	=> $this->status,
			'code'		=> $this->code
		];
	}
}
