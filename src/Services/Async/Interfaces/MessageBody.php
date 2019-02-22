<?php
/**
 * Filename: MessageBody.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:16
 */

namespace Services\Async\Interfaces;

interface MessageBody {

    public function setProvider($provider);

    public function getProvider();

    public function setTriggerTime($trigger_time);

    public function getTriggerTime();

    public function setExecutorHandler($executor);

    public function getExecutorHandler();

    public function setParams(array $params);

    public function getParams();

    public function __toString();

}