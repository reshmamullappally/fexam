@extends('layouts.app')

@section('title', 'Fxam')
@section('content')
   
      
    <!-- Start block -->
    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
            <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
                <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{$course->name}}</h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    {{$course->details}}
                </p>
            </div>
             <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                @foreach($exams as $exam)
                <!-- Pricing Card -->
                <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                    <h3 class="mb-4 text-2xl font-semibold">{{$exam->name}}</h3>
                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400 mb-4">{{$exam->details}}</p>
                    <!-- List -->
                    <a href="{{route('exam',$exam->slug)}}" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">View</a>
                </div>
                @endforeach
              
            </div>
           
        </div>
      </section>
    <!-- End block -->
    
    <script src="{{asset('js/flowbite.js')}}"></script>
@endsection