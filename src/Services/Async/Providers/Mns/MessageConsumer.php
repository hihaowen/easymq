<?php
/**
 * Filename: MessageConsumer.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:42
 */

namespace Services\Async\Providers\Mns;

class MessageConsumer implements \Services\Async\Interfaces\MessageConsumer {

    protected $_queue = null;

    private static $_instance = [];

    private $_current_receipt_handle = null;
    private $_current_message_body = null;

    private function __construct($queue_name) {

        $this->_queue = new MessageQueue($queue_name);
    }

    public static function getInstance($queue_name) {

        if( ! isset(self::$_instance[$queue_name]) ) {
            self::$_instance[$queue_name] = new self($queue_name);
        }

        return self::$_instance[$queue_name];
    }

    public function fetchMessageBody() {

        $xml_str = $this->_queue->fetchMessage();
        $xml_obj = simplexml_load_string($xml_str);

        $message_body_str = (string) $xml_obj->MessageBody;

        if( empty($message_body_str) ) {
            echo 'fetch Message is empty.', PHP_EOL;
            return false;
        }

        echo 'fetch Message ok. body: [ ', $message_body_str, ' ]', PHP_EOL;

        $this->_current_message_body = new MessageBody($message_body_str);
        $this->_current_receipt_handle = (string) $xml_obj->ReceiptHandle;

        return $this->_current_message_body;
    }

    public function deleteMessage() {

        echo 'delete Message ok. receipt_handle: ', $this->_current_receipt_handle, PHP_EOL;

        $this->_queue->deleteMessage(
            $this->_current_receipt_handle
        );

    }

}