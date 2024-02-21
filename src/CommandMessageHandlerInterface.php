<?php

namespace WebImage\ProtocolCommander;

use WebImage\ServerTalk\ConnectionInterface;
use WebImage\ServerTalk\MessageInterface;

interface CommandMessageHandlerInterface {
	public function handleCommand(Command $command, ConnectionInterface $connection, MessageInterface $message);
}
