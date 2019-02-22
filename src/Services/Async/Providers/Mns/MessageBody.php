<?php
/**
 * Filename: MessageBody.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:45
 */

namespace Services\Async\Providers\Mns;

class MessageBody implements \Services\Async\Interfaces\MessageBody {

    protected $_provider = null;
    protected $_trigger_time = null;
    protected $_executor = null;
    protected $_params = [];

    public function __construct(string $message_body = null) {

        if(!is_null($message_body)) {
            $message_body_arr = unserialize($message_body);
            isset($message_body_arr['provider']) && ($this->_provider = $message_body_arr['provider']);
            isset($message_body_arr['trigger_time']) && ($this->_trigger_time = $message_body_arr['trigger_time']);
            isset($message_body_arr['executor']) && ($this->_executor = $message_body_arr['executor']);
            isset($message_body_arr['params']) && ($this->_params = $message_body_arr['params']);
        }
    }

    public function setProvider($provider) {
        $this->_provider = $provider;
    }

    public function getProvider() {
        return $this->_provider;
    }

    public function setTriggerTime($trigger_time) {
        $this->_trigger_time = (int) $trigger_time;
        return $this;
    }

    public function getTriggerTime() {
        return $this->_trigger_time;
    }

    public function setExecutorHandler($executor) {
        $this->_executor = $executor;
        return $this;
    }

    public function getExecutorHandler() {
        return $this->_executor;
    }

    public function setParams(array $params) {
        $this->_params = $params;
    }

    public function getParams() {
        return $this->_params;
    }

    public function __toString() {
        return serialize(
            [
                'provider' => $this->getProvider(),
                'trigger_time' => $this->getTriggerTime(),
                'executor' => $this->getExecutorHandler(),
                'params' => $this->getParams(),
            ]
        );
    }

}