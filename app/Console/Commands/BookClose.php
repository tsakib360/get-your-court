<?php

namespace App\Console\Commands;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BookClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically close book';

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
        $current = Carbon::now();
        $books = Book::where('booking_time', '<=', $current)
                            ->update(['approve' => 2]);
                            
    }
}
