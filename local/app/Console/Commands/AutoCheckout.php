<?php

namespace App\Console\Commands;

use App\Models\Checkout;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-checkout-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Checkout::where('status',0)->whereDate('charge','<=',Carbon::now())->update([
            'status' => 1
        ]);
        return 'ok';
    }
}
