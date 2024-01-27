<?php

namespace WebImage\ProtocolCommander;

use WebImage\ServerTalk\ConnectionInterface;
use WebImage\ServerTalk\MessageInterface;

interface CommandMessageHandlerInterface {
	public function handleCommand(MessageInterface $message, ConnectionInterface $connection, Command $command);
}
