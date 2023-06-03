<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $title;
    public $body;
    public $token;
    public $type;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title,$body,$token,$type,$data)
    {
        $this->title = $title;
        $this->body = $body;
        $this->token = $token;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sendUserAppNotification($this->title,$this->body,$this->token,array('type'=>$this->type,'data'=>array('data'=>$this->data)));
        var_dump("Yes done send notification");
    }
}
