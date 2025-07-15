<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Exam;
use App\Services\QuestionExtractor;

class TestExamExtraction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:extract';

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
        $exam = Exam::latest()->first(); // get the latest uploaded exam

    if (!$exam) {
        $this->error('No exam found in DB.');
        return;
    }

    $this->info("Running extraction for exam: {$exam->name}");

    $questions = QuestionExtractor::run($exam);

    $this->info("Extracted and saved " . count($questions) . " questions.");
    }
}
