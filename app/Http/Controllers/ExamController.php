<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index($slug)
    {
        
        $exam = Exam::where('slug', $slug)->firstOrFail();
        return view('exam', [
            'exam' => $exam
        ]);
    }
}
