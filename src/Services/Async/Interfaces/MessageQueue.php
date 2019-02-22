<?php
/**
 * Filename: MessageQueue.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:22
 */

namespace Services\Async\Interfaces;

interface MessageQueue {

    public function __construct($queue_name);

    public function fetchQueue();

    public function createQueue();

    public function updateQueue();

    public function deleteQueue();

    public function createMessage(string $message_content);

    public function deleteMessage($unique_key);

    public function fetchMessage();

}