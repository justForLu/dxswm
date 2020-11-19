<?php
namespace App\Services\Socket;

/**
 * Created by PhpStorm.
 * User: ibm
 * Date: 2017/2/27
 * Time: 10:07
 */
class SocketClientService
{
    private $host;    //要连接的主机IP地址
    private $prot;    //连接端口号
    private $Error = array();
    private $socket = NULL;    //连接标识
    private $queryStr = ''; //发送的数据

    public function __construct()
    {
        if (!extension_loaded("sockets")) {
            throw new \Exception('请打开socket扩展');
        }
        $config = config('rcu.socket');
        $this->host = $config['ip'];
        $this->port = $config['managersocket_port'];
    }

    //创建socket
    private function CreateSocket()
    {
        //创建socket
        !$this->socket && $this->socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP);

        $time = time();
        $timeout = 10;

        $r = @socket_connect($this->socket, $this->host, $this->port);
//        socket_set_option($this->socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>1, "usec"=>0 ) );
//        socket_set_option($this->socket,SOL_SOCKET,SO_SNDTIMEO,array("sec"=>3, "usec"=>0 ) );
        if (!$r) {
            throw new \Exception('socket连接失败');
        }
    }

    //向socket服务器写入数据
    public function sendMsg($contents)
    {
        $this->queryStr = $contents;
        !$this->socket && $this->CreateSocket();
        $contents = $this->fliterSendData($contents);
        $result = socket_write($this->socket, $contents, strlen($contents));
        if (!intval($result)) {
            throw new \Exception('socket 数据写入失败');
            $this->error[] = socket_last_error($this->socket);
            return false;
        } else {
            return $result;
        }


    }

    //读取数据
    public function getMsg($len)
    {
        $response = socket_read($this->socket, $len);
        if (false === $response) {
            $this->error[] = socket_last_error($this->socket);
            return false;
        }
        return $response;
    }

    //对发送的数据进行过滤
    private function fliterSendData($contents)
    {
        //可以写自己的对写入的数据过滤代码
        return $contents;
    }

    //所有错误信息
    public function getError()
    {
        return $this->error;
    }

    //最后一次错误信息
    public function getLastError()
    {
        return socket_strerror($this->error(count($this->error)));
    }

    //获取最后一次发送的消息
    public function getLastMsg()
    {
        return $this->queryStr;
    }

    //获取连接主机的地址
    public function getHost()
    {
        return $this->host;
    }

    //获取要连接的端口号
    public function getPort()
    {
        return $this->port;
    }

    //关闭socket连接
    private function close()
    {
        $this->socket && socket_close($this->socket);
        $this->socket = NULL; //资源初始化
    }

    //析构函数
    public function __destruct()
    {
        $this->close();
    }
}