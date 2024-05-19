<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assignment;
use Carbon\Carbon;

class CheckAssignmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assignment:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check assignment status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $assignments = Assignment::where('closed', false)
                ->where('closing', true)
                ->where(function ($query) {
                $query->where('due_date', '<', Carbon::today())
                ->orWhere(function ($query) {
                        $query->whereDate('due_date', '=', Carbon::today())
                        ->whereTime('due_hour', '<', Carbon::now()->format('H:i:s'));
                    });
            })
            ->get();

        foreach ($assignments as $assignment) {
            $assignment->closed = true;
            $assignment->save();
        }
    }
}
