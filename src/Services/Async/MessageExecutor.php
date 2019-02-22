<?php
/**
 * Filename: MessageExecutor.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午9:55
 */

namespace Services\Async;

use Services\Async\Factories\ConsumerFactory;
use Services\Async\Interfaces\MessageBody;
use Services\Async\Interfaces\MessageExecutorHandler;

class MessageExecutor {

    private $_handlers = [];

    public function __construct() {
    }

    public function register(MessageExecutorHandler $handler) {
        $queue_name = $handler::getQueueName();
        $this->_handlers[$queue_name][] = $handler;
    }

    public function notify() {

        foreach($this->_handlers as $queue_name => $handler_items) {

            try {
                // 拉取消息
                $consumer = ConsumerFactory::createConsumer($queue_name);
                $message_body = $consumer->fetchMessageBody();

                if( !($message_body instanceof MessageBody) ) {

                    if( is_object($message_body) )
                        echo 'Message Body is not instanceof MessageBody, it\'s class name: ',
                        get_class($message_body), PHP_EOL;

                    continue;
                }

                $executor_class_name = $message_body->getExecutorHandler();

                // 查看消息是否存在与当前 handler 匹配
                foreach($handler_items as $handler_item) {

                    if( ! ($handler_item instanceof MessageExecutorHandler) ) {

                        echo 'handler_item is not instanceof MessageExecutorHandler, it\'s class name: ',
                        get_class($handler_item),PHP_EOL;

                        continue;
                    }

                    $executor_contrast_class_name = get_class($handler_item);

                    // 如果不是待执行的对象
                    if( $executor_class_name != $executor_contrast_class_name ) {

                        echo '$executor_class_name != $executor_contrast_class_name, ',
                        '$executor_class_name: ', $executor_class_name,
                        ', $executor_contrast_class_name: ',
                        $executor_contrast_class_name, PHP_EOL;

                        continue;
                    }

                    // 待执行的对象未满足条件
                    if( ! $handler_item->check() ) {

                        echo '$handler_item check failed. ',
                        '$executor_contrast_class_name: ',
                        $executor_contrast_class_name, PHP_EOL;

                        continue;
                    }

                    // 执行业务逻辑
                    $handler_item->process($message_body);

                    // 用完删除该条消息
                    $consumer->deleteMessage();
                }
            } catch (\Exception $e) {
                throw $e;
            }

        }
    }

}