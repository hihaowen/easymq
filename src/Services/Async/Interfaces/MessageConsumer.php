<?php
/**
 * Filename: MessageConsumer.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:29
 */

namespace Services\Async\Interfaces;

interface MessageConsumer {

    public function fetchMessageBody();

    public function deleteMessage();

}