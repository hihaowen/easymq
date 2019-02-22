<?php
/**
 * Filename: MessageExecutorHandler.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:14
 */

namespace Services\Async\Interfaces;

interface MessageExecutorHandler {

    public function process(MessageBody $message_body);

    public function check();

    public static function getQueueName();

}