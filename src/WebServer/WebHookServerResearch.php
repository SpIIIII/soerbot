<?php
namespace SoerBot\WebServer;
    //composer require react/http:^0.8.1
    //composer require react/socket:^1.2
    use Psr\Http\Message\ServerRequestInterface;
    use React\Http\Response;
    use React\Http\Server;
    use React\EventLoop\Factory;
    use React\Socket\Server as Socket;
    
class WebHookServerResearch
{
    private $loop; 
    private $server;
    private $socket;
    public function __construct($aLoop)
    {
        $this -> loop = $aLoop; 
        echo "WebHookServerResearch has created\n";
    }
    
    public function StartServer()
    {
        // https://reactphp.org/
        // see example api: https://habr.com/ru/post/143317/
        $this -> server = new Server(function (ServerRequestInterface $request) {
            return new Response(
                200,
                array('Content-Type' => 'text/plain'),
                "Hello World!\n"
            );
        });
        $this -> socket = new Socket(8080,  $this -> loop);
        $this -> server->listen( $this -> socket);
        echo "Server running at http://127.0.0.1:8080\n";
    }
}