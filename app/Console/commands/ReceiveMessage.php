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
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

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
                $this->client = new Client(env("QUEUE_MNS_ENDPOINT"), env("QUEUE_MNS_ACCESS_KEY"),
                    env("QUEUE_MNS_SECRET_KEY"));
                $queue = $this->client->getQueueRef("aliyun-iot-a1GBdrPMPst");
                $res = $queue->receiveMessage(30);
                echo "ReceiveMessage Succeed! \n";
                $body = $res->getMessageBody();
                $receiptHandle = $res->getReceiptHandle();
                Log::debug("msn:receive".serialize($body));
            } catch (MnsException $e) {
                echo "ReceiveMessage Failed: " . $e . "\n";
                echo "MNSErrorCode: " . $e->getMnsErrorCode() . "\n";
                Log::debug("MNSErrorCode: ".serialize($e->getMessage()));
                return;
            }

        }
    }

}
