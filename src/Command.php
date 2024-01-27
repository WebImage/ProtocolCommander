<?php

namespace WebImage\ProtocolCommander;

class Command {
	/**
	 * @var string
	 */
	private $command;
	/**
	 * @var string
	 */
	private $data;

	/**
	 * Command constructor.
	 *
	 * @param string $command
	 * @param string $data
	 */
	public function __construct(string $command, string $data=null)
	{
		$this->command = strtoupper($command);
		$this->data = $data;
	}

	// Convenience method for chaining
	public static function create(string $command, string $data=null)
	{
		return new self($command, $data);
	}

	public static function createFromString($data)
	{
		list($command, $data) = array_pad(explode(' ', $data, 2), 2, '');

		return new self($command, $data);
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->command;
	}

	/**
	 * @return string
	 */
	public function getData(): string
	{
		return $this->data;
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		return strlen($this->getData()) == 0 ? $this->getName() : sprintf('%s %s', $this->getName(), $this->getData());
	}
}
