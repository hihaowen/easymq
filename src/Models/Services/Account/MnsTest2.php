<?php
/**
 * Filename: MnsTest2.php.
 * User: George
 * Date: 2018/4/27
 * Time: 上午11:55
 */

namespace Services\Account;

use Services\Async\Abstracts\AsyncTaskHandler;
use Services\Async\Interfaces\MessageBody;

class MnsTest2 extends AsyncTaskHandler {

    public function process(MessageBody $message_body) {

        error_log('Well Done for Mns Test 2. Params: ' .
            print_r(
                $message_body->getParams(),
                true
            )
        );

        echo 'run done.', PHP_EOL;

        return true;
    }

}