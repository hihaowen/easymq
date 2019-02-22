<?php
/**
 * Filename: AsyncTaskHandler.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:31
 */

namespace Services\Async\Abstracts;

use Services\Async\Factories\ProducerFactory;
use Services\Async\Interfaces\MessageBody;
use Services\Async\Interfaces\MessageExecutorHandler;

abstract class AsyncTaskHandler implements MessageExecutorHandler {

    public static function getQueueName() {
        return 'task1';
    }

    public function check() {
        return true;
    }

    final function call(array $params = [], $sec = 0) {

        $producer = ProducerFactory::createProducer(
            self::getQueueName()
        );

        $message_body = ProducerFactory::createMessageBody();
        $message_body->setTriggerTime((int) $sec);
        $message_body->setExecutorHandler(get_class($this));
        $message_body->setProvider('mns');
        $message_body->setParams($params);

        return $producer->create((string) $message_body);
    }

    abstract public function process(MessageBody $message_body);

}