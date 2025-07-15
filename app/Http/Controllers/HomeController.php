<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $exams=Exam::latest()->get();
        $courses=Course::latest()->take(3)->get();
        return view('home', [
            'exams' => $exams,
            'courses'=>$courses
        ]);
    }
}
