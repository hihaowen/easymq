<?php
/**
 * Filename: ProducerFactory.php.
 * User: George
 * Date: 2018/4/26
 * Time: 上午11:45
 */

namespace Services\Async\Factories;

use Services\Async\Providers\Mns\MessageBody;
use Services\Async\Providers\Mns\MessageProducer;
use Services\Async\Providers\Mns\MessageQueue;

class ProducerFactory {

    public static function createProducer($queue_name, $provider = 'mns') {

        switch($provider) {
            case 'mns' :
                $producer = MessageProducer::getInstance($queue_name);
                break;

            default :
                $producer = MessageProducer::getInstance($queue_name);
                break;
        }

        return $producer;
    }

    public static function createMessageBody($provider = 'mns') {

        switch($provider) {
            case 'mns' :
                $message_body = new MessageBody(null);
                break;

            default :
                $message_body = new MessageBody(null);
                break;
        }

        return $message_body;
    }

    public static function createMessageQueue($queue_name, $provider = 'mns') {

        switch($provider) {
            case 'mns' :
                $message_body = new MessageQueue($queue_name);
                break;

            default :
                $message_body = new MessageQueue($queue_name);
                break;
        }

        return $message_body;
    }

}