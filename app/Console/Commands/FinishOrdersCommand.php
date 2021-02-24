<?php

namespace App\Console\Commands;

use App\Order;
use App\OrderStatus;
use Illuminate\Console\Command;

class FinishOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Перевести все заказы в статус выполнено';

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
        Order::where('status_id', '<>', OrderStatus::FINISH_STATUS_ID)->update(['status_id' => OrderStatus::FINISH_STATUS_ID]);

        return true;
    }
}
