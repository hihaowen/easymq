<?php
/**
 * Filename: ConsumerFactory.php.
 * User: George
 * Date: 2018/4/26
 * Time: 上午11:50
 */

namespace Services\Async\Factories;

use Services\Async\Providers\Mns\MessageConsumer;

class ConsumerFactory {

    public static function createConsumer($queue_name, $provider = 'mns') {

        switch($provider) {
            case 'mns' :
                $producer = MessageConsumer::getInstance($queue_name);
                break;

            default :
                $producer = MessageConsumer::getInstance($queue_name);
                break;
        }

        return $producer;
    }

}