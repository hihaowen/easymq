<?php
/**
 * Filename: MessageProducer.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:27
 */

namespace Services\Async\Interfaces;

interface MessageProducer {

    public function create(string $message_body);

}