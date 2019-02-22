<?php
/**
 * Filename: test_mq.php.
 * User: George
 * Date: 2018/4/27
 * Time: 上午12:10
 */

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));

require_once ROOT_PATH . '/src/Services/Async/Interfaces/MessageExecutorHandler.php';
require_once ROOT_PATH . '/src/Services/Async/Abstracts/AsyncTaskHandler.php';
require_once ROOT_PATH . '/src/Models/Services/Account/MnsTest.php';
require_once ROOT_PATH . '/src/Models/Services/Account/MnsTest2.php';
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

$mns = new \Services\Account\MnsTest();

print_r(
    $mns->call(
        [
            'tag' => 'test1',
            'arg1' => 'val1',
            'arg2' => 'val2',
            'arg3' => 'val3',
        ]
    )
);

$mns = new \Services\Account\MnsTest2();

print_r(
    $mns->call(
        [
            'tag' => 'test2',
            'arg1' => 'val4',
            'arg2' => 'val5',
            'arg3' => 'val6',
        ]
    )
);
