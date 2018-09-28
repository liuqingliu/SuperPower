<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/4
 * Time: 17:45
 */
namespace App\Console\Commands;

use AliyunMNS\Client;
use AliyunMNS\Exception\MnsException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReceiveMessage extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ReceiveMessage:receive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这里接收阿里云msn消息.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while (1) {
            $receiptHandle = null;
            try {
                Log::info("msn:real_msg-starting");
                $this->client = new Client(env("QUEUE_MNS_ENDPOINT"), env("QUEUE_MNS_ACCESS_KEY"),
                    env("QUEUE_MNS_SECRET_KEY"));
                $queue = $this->client->getQueueRef("aliyun-iot-a1GBdrPMPst");
                $res = $queue->receiveMessage(30);
                echo "ReceiveMessage Succeed! \n";
                $body = json_decode($res->getMessageBody());
                $message = base64_decode($body->payload);
                $realMsg = json_decode($message, true);
                $receiptHandle = $res->getReceiptHandle();
                Log::info("msn:real_msg".serialize($realMsg));
                if (isset($realMsg["func"])) {
                    $func = "App\Events\Msns\\".$realMsg["func"];
                    if (!class_exists($func)) {
                        return;
                    }
                    event(new $func($realMsg));
                }
                if (isset($realMsg["status"]) && ($realMsg["status"] == "online" || $realMsg["status"] == "offline") ) {
                    $func = "App\Events\Msns\\changeNet";
                    event(new $func($realMsg["deviceName"], $realMsg["status"]));
                }
            } catch (MnsException $e) {
                echo "ReceiveMessage Failed: " . $e . "\n";
                echo "MNSErrorCode: " . $e->getMnsErrorCode() . "\n";
                Log::debug("ReceiveMessage-error: ".serialize($e->getMessage()));
//                exit;
            }

            if($receiptHandle){
                try
                {
                    $delres = $queue->deleteMessage($receiptHandle);
                }
                catch (MnsException $e)
                {
                    echo "deleteMessage Failed: " . $e . "\n";
                    echo "MNSErrorCode: " . $e->getMnsErrorCode() . "\n";
                    Log::debug("deleteMessage-error: ".serialize($e->getMessage()));
                    return;
                }
            }
        }
    }

}
