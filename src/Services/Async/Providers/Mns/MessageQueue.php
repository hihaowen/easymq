<?php
/**
 * Filename: MessageQueue.php.
 * User: George
 * Date: 2018/4/25
 * Time: 下午10:44
 */

namespace Services\Async\Providers\Mns;

use Services\Async\Configs;
use Services\Utils\Http\HttpClient;

class MessageQueue implements \Services\Async\Interfaces\MessageQueue {

    private $_access_id = Configs::ACCESS_ID;
    private $_access_key = Configs::ACCESS_KEY;
    private $_endpoint = Configs::ENDPOINT;

    protected $_queue_name = null;

    public function __construct($queue_name) {
        $this->_queue_name = $queue_name;
    }

    public function fetchQueue() {

        $method = 'GET';
        $uri = '/queues/' . $this->_queue_name;
        $url = $this->_endpoint . $uri;
        $body = <<<XML
XML;

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    public function createQueue() {

        $method = 'PUT';
        $uri = '/queues/' . $this->_queue_name;
        $url = $this->_endpoint . $uri;
        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Queue xmlns="http://mns.aliyuncs.com/doc/v1/">
    <VisibilityTimeout>60</VisibilityTimeout>
    <MaximumMessageSize>65536</MaximumMessageSize>
    <MessageRetentionPeriod>1209600</MessageRetentionPeriod>
    <DelaySeconds>604800</DelaySeconds>
    <LoggingEnabled>False</LoggingEnabled>
</Queue>
XML;

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    public function updateQueue() {

        $method = 'PUT';
        $uri = '/queues/' . $this->_queue_name;
        $url = $this->_endpoint . $uri;
        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Queue xmlns="http://mns.aliyuncs.com/doc/v1/">
    <VisibilityTimeout>60</VisibilityTimeout>
    <MaximumMessageSize>65536</MaximumMessageSize>
    <MessageRetentionPeriod>1209600</MessageRetentionPeriod>
    <DelaySeconds>604800</DelaySeconds>
    <LoggingEnabled>False</LoggingEnabled>
    <PollingWaitSeconds>30</PollingWaitSeconds>
</Queue>
XML;

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    public function deleteQueue() {

        $method = 'DELETE';
        $uri = '/queues/' . $this->_queue_name;
        $url = $this->_endpoint . $uri;
        $body = <<<XML
XML;

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    public function createMessage(string $message_content) {

        $method = 'POST';
        $uri = '/queues/' . $this->_queue_name . '/messages';
        $url = $this->_endpoint . $uri;
        $body = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Message xmlns="http://mns.aliyuncs.com/doc/v1/">
    <MessageBody>%s</MessageBody>
    <DelaySeconds>0</DelaySeconds>
    <Priority>1</Priority>
</Message>
XML;
        $body = sprintf($body, $message_content);

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    public function deleteMessage($unique_key) {

        $method = 'DELETE';
        $uri = '/queues/' . $this->_queue_name . '/messages?ReceiptHandle=' . $unique_key;
        $url = $this->_endpoint . $uri;
        $body = <<<XML
XML;

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    /**
     * https://help.aliyun.com/document_detail/35136.html?spm=a2c4g.11186623.6.711.OUevNm
     * @return mixed
     */
    public function fetchMessage() {

        $method = 'GET';
        $uri = '/queues/' . $this->_queue_name . '/messages?waitseconds=1';
        $url = $this->_endpoint . $uri;
        $body = <<<XML
XML;

        $headers = $this->getBasicHeaaders($method, $uri);

        return HttpClient::request($method, $url, $body, $headers);
    }

    private function getBasicHeaaders($method, $uri) {

        $canonicalized_mns_headers = 'x-mns-version:2015-06-06';
        $canonicalized_resource = $uri;
        $date_str = gmdate("D, d M Y H:i:s \\G\\M\\T");

        $sign_str = $method . "\n"
            . '' . "\n"
            . 'text/xml' . "\n" // Content-type
            . $date_str . "\n"
            . $canonicalized_mns_headers . "\n"
            . $canonicalized_resource;

        $authorization = base64_encode(
            hash_hmac("sha1", $sign_str, $this->_access_key, $raw_output = TRUE)
        );

        $headers = [
            // 'User-Agent: test by George',
            'Date: ' . $date_str,
            'Authorization: MNS ' . $this->_access_id . ':' . $authorization,
            'Content-type: text/xml',
            'x-mns-version: 2015-06-06',
        ];

        return $headers;
    }

}