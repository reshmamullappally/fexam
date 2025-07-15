@extends('layouts.app')

@section('title', 'Fxam')
@section('content')
    <!-- Start block -->
    <!-- <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">Welcome to FExam </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">FExam is a free and easy-to-use online exam portal designed for students preparing for competitive and academic exams.</p>
               
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{asset('images/hero.png')}}" alt="hero image">
            </div>                
        </div>
    </section> -->
    <!-- End block -->
   
    

  
    <!-- Start block -->
    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
            <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
                <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">FExam — Free Online Exam Platform</h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    FExam is a free and easy-to-use online exam portal designed for students preparing for competitive and academic exams. Practice multiple-choice questions (MCQs), get instant results, and track your progress over time — all for free! No registration fees, no hidden costs. Whether you're preparing for school tests, government exams, or just want to improve your knowledge, FExam helps you stay ahead. Start learning, testing, and growing — absolutely free!
                </p>
            </div>
            <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                @foreach($courses as $course)
                <!-- Pricing Card -->
                <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                    <h3 class="mb-4 text-2xl font-semibold">{{$course->name}}</h3>
                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">{{$course->details}}</p>
                    <div class="flex items-baseline justify-center my-8">
                        <span class="mr-2 text-5xl font-extrabold">$0</span>
                        <span class="text-gray-500 dark:text-gray-400">/month</span>
                    </div>
                    <!-- List -->
                    <a href="{{route('course',$course->slug)}}" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a>
                </div>
                @endforeach
              
            </div>
        </div>
      </section>
    <!-- End block -->
   
   
    <script src="{{asset('js/flowbite.js')}}"></script>
@endsection