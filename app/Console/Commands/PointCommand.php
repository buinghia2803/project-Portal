<?php

namespace App\Console\Commands;

use App\Models\Point;
use Illuminate\Console\Command;

class PointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:point_command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $points = Point::all()->pluck('id');

        Point::whereIn('id',$points)->update([
            'month_point' => 0,
        ]);
    }
}
