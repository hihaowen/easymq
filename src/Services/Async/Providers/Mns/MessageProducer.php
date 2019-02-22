<?php
/**
 * Filename: MessageProducer.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:40
 */

namespace Services\Async\Providers\Mns;

class MessageProducer implements \Services\Async\Interfaces\MessageProducer {

    private static $_instance = [];

    protected $_queue = null;

    private function __construct($queue_name) {

        $this->_queue = new MessageQueue($queue_name);
    }

    public static function getInstance($queue_name) {

        if( !isset(self::$_instance[$queue_name]) ) {
            self::$_instance[$queue_name] = new self($queue_name);
        }

        return self::$_instance[$queue_name];
    }

    public function create(string $message_body) {
        return $this->_queue->createMessage($message_body);
    }

}