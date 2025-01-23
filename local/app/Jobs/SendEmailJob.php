<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailDetail;
    public $emailTitle;
    public $emailUser;

    public function __construct($emailDetail,$emailTitle,$emailUser)
    {
        $this->emailDetail = $emailDetail;
        $this->emailTitle = $emailTitle;
        $this->emailUser = $emailUser;
    }

    public function handle()
    {
        if(env('MAIL_FROM_ADDRESS')){
            Mail::to($this->emailUser)->send(new sendMail($this->emailTitle , $this->emailDetail , env('MAIL_FROM_ADDRESS')));
        }
    }
}
