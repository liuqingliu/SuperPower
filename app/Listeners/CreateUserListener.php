<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\CreateUser;
use Illuminate\Contracts\Logging\Log;

class CreateUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(CreateUser $event)
    {
        //
        return $event->user->save();
    }

    /**
     * 处理任务失败
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(CreateUser $event, $exception)
    {
        //错误log
        Log::info("pos:".__FUNCTION__.",error:".serialize($exception));
    }
}
