Using WebImage/ServerTalk, Protocol Commander sets up a command based messaging protocol, like FTP, that can be used to send commands to and from a server.

$protocol = new MessageProtocol();
$protocol->command('SOMECOMMAND',  new SomeComandMessageHandler());

$server = new WebImage/ServerTalk/Server();
$server->onMessage(function(MessageInterface $msg, ConnectionInterface $conn) use ($protocol) {
    $protocol->handleMessage($msg, $conn);
});
