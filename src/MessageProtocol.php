<?php

namespace WebImage\ProtocolCommander;

use WebImage\ServerTalk\ConnectionInterface;
use WebImage\ServerTalk\MessageInterface;

class MessageProtocol {
	private $commands = [];

	public function command(string $command, CommandMessageHandlerInterface $handler)
	{
		$this->commands[$command] = $handler;
	}

	/**
	 * @param MessageInterface $message
	 * @param ConnectionInterface $connection
	 *
	 * @return bool Whether the message was handled
	 */
	public function handleMessage(MessageInterface $message, ConnectionInterface $connection)
	{
		// Parse the command from the message received (format: CMD [data])
		$command = Command::createFromString($message->getData());
		/** @var CommandMessageHandlerInterface $handler */
		$handler = isset($this->commands[$command->getName()]) ? $this->commands[$command->getName()] : null;

		if ($handler === null) {
			$connection->write('400 Invalid command ' . $command->getName());
			$connection->close();
			return false;
		}

		$handler->handleCommand($command, $connection, $message);

		return true;
	}
}
