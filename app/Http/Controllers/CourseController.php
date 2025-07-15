<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index($slug)
    {
        $course=Course::where('slug', $slug)->firstOrFail();
        $exams=Exam::where('course_id', $course->id)->get();
        return view('course', [
            'exams' => $exams,
            'course'=>$course
        ]);
    }
}
