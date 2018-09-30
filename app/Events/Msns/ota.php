<?php
/**
 * Created by PhpStorm.
 * User: liuqing
 * Date: 2018/9/5
 * Time: 23:02
 */


namespace App\Events\Msns;

use Illuminate\Queue\SerializesModels;

class ota
{
    use SerializesModels;

    public $devid;

    public $version;

    public $offset;

    public $size;

    /**
     * 创建一个事件实例。
     *
     * @param  $message
     * @return void
     */
    public function __construct($message)
    {
        $this->devid = $message["devid"];
        $this->version = $message["version"];
        $this->offset = $message["offset"];
        $this->size = $message["size"];
    }
}