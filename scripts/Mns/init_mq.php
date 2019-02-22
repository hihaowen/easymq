<?php
/**
 * Filename: init_mq.php.
 * User: George
 * Date: 2018/4/27
 * Time: 上午12:31
 */

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));

require_once ROOT_PATH . '/src/Services/Async/Interfaces/MessageExecutorHandler.php';
require_once ROOT_PATH . '/src/Services/Async/Abstracts/AsyncTaskHandler.php';
require_once ROOT_PATH . '/src/Models/Services/Account/MnsTest.php';
require_once ROOT_PATH . '/src/Services/Async/Factories/ConsumerFactory.php';
require_once ROOT_PATH . '/src/Services/Async/Factories/ProducerFactory.php';
require_once ROOT_PATH . '/src/Services/Async/Interfaces/MessageBody.php';
require_once ROOT_PATH . '/src/Services/Async/Interfaces/MessageConsumer.php';
require_once ROOT_PATH . '/src/Services/Async/Interfaces/MessageProducer.php';
require_once ROOT_PATH . '/src/Services/Async/Interfaces/MessageQueue.php';
require_once ROOT_PATH . '/src/Services/Async/Providers/Mns/MessageProducer.php';
require_once ROOT_PATH . '/src/Services/Async/Providers/Mns/MessageConsumer.php';
require_once ROOT_PATH . '/src/Services/Async/Providers/Mns/MessageBody.php';
require_once ROOT_PATH . '/src/Services/Async/Providers/Mns/MessageQueue.php';
require_once ROOT_PATH . '/src/Services/Utils/Http/HttpClient.php';
require_once ROOT_PATH . '/src/Services/Async/Configs.php';

// 创建队列

print_r(
    \Services\Async\Factories\ProducerFactory::createMessageQueue(
        \Services\Async\Abstracts\AsyncTaskHandler::getQueueName(),
        'mns'
    )->createQueue()
);