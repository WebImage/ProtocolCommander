<?php

namespace WebImage\ProtocolCommander;

use WebImage\ServerTalk\ConnectionInterface;
use WebImage\ServerTalk\MessageInterface;

abstract class AbstractCommandMessageHandler implements CommandMessageHandlerInterface
{
	/**
	 * Get all connections on the server that are not $thisConnection
	 * @param ConnectionInterface $excludeConnection
	 *
	 * @return ConnectionInterface[]
	 */
	public function getOtherConnections(ConnectionInterface $conn, callable $filter = null)
	{
		$connections = [];

		/** @var ConnectionInterface $connection */
		foreach($conn->getServer()->getConnections() as $tConn) {
			if ($tConn === $conn) continue; // Do not send to own connection
			$include = true;

			if ($filter !== null) {
				$res = call_user_func($filter, $tConn); // custom filter must return bool
				if (!is_bool($res)) {
					echo 'Filter must return boolean value';
					continue;
				}
				$include = $res;
			}

			if ($include) $connections[] = $tConn;
		}

		return $connections;
	}

	/**
	 * @param  $message
	 * @param ConnectionInterface $connection
	 * @param Command $command
	 */
	public function handleCommand(Command $command, ConnectionInterface $connection, MessageInterface $message)
	{
		$this->executeCommand($message, $connection, $command);

		$ctx = $connection->getContext();
		$ctx->set('lastCommand', $command->getName());
		$ctx->set('lastInteraction', time());
	}

	/**
	 * Parse a data string into multiple parts, separated by spaces
	 * @param string $str
	 * @param int $num
	 *
	 * @return array
	 */
	protected function parseDataString(string $str, int $num)
	{
		return array_pad(explode(' ', $str, $num), $num, '');
	}

	abstract protected function executeCommand(MessageInterface $message, ConnectionInterface $connection, Command $command);
}
