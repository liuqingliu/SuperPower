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
use AliyunMNS\Requests\BatchReceiveMessageRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearAllMsnMessage extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ClearAllMsnMessage:clearAll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这里清空阿里云msn消息.';

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
        $endTime = time();
        while (1) {
            $receiptHandle = null;
            try {
                Log::info("msn:clearall");
                $this->client = new Client(env("QUEUE_MNS_ENDPOINT"), env("QUEUE_MNS_ACCESS_KEY"),
                    env("QUEUE_MNS_SECRET_KEY"));
                $queue = $this->client->getQueueRef("aliyun-iot-a1GBdrPMPst");
                $batchRecieve = new BatchReceiveMessageRequest(10, 30);
                $res = $queue->batchReceiveMessage($batchRecieve);
                if(!$res->isSucceed()){
                    exit("批量消费消息失败");
                }
                $messages = $res->getMessages();
                $receiptHandles = [];
                foreach ($messages as $message)
                {
                    $nowTime = $message->getEnqueueTime();
                    echo "now_time:".date("Y-m-d H:i:s",$endTime).",enqueue_time:".$nowTime."\n";
                    if ($endTime < substr($nowTime, 0, 10)) {
                        exit;
                    }
                    $receiptHandles[] = $message->getReceiptHandle();
                }
                echo "batchReceiveMessage success!\n";
            } catch (MnsException $e) {
                echo "batchReceiveMessage Failed: " . $e . "\n";
                echo "batchMNSErrorCode: " . $e->getMnsErrorCode() . "\n";
                Log::debug("batchReceiveMessage-error: ".serialize($e->getMessage()));
                exit;
            }

            if(!empty($receiptHandles)){
                try
                {
                    $res = $queue->batchDeleteMessage($receiptHandles);
                    echo "batchDeleteMessage success!\n";
                    if(!$res){
                        exit("批量删除消息失败");
                    }
                }
                catch (MnsException $e)
                {
                    echo "batchdeleteMessage Failed: " . $e . "\n";
                    echo "MNSErrorCode: " . $e->getMnsErrorCode() . "\n";
                    Log::debug("deleteMessage-error: ".serialize($e->getMessage()));
                    exit;
                }
            }else{
                exit("没有消息了");
            }
        }
    }

}
