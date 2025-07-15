@extends('layouts.app')

@section('title', 'Fxam')
@section('content')
   
      
    <!-- Start block -->
    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
            <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
                <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{$exam->course->name}}-{{$exam->name}}</h2>
                <div class="mb-5">
                    <div class="mb-4">
                        <button onclick="prevPage()">Previous</button>
                        <button onclick="nextPage()">Next</button>
                        <span>Page: <span id="page-num">1</span> / <span id="page-count">--</span></span>
                    </div>
                    <canvas id="pdf-canvas" style="border: 1px solid #ddd; max-width: 100%;"></canvas>
                </div>
            </div>
            
           
        </div>
      </section>
    <!-- End block -->

 
   
   
    <script src="{{asset('js/flowbite.js')}}"></script>
    {{-- Load PDF.js --}}
    <script src="{{asset('js/pdf.min.js')}}"></script>

    <script>
        const url = "{{ asset('storage/'.$exam->file_path) }}";
        let pdfDoc = null, pageNum = 1, pageRendering = false, canvas = document.getElementById('pdf-canvas'), ctx = canvas.getContext('2d');

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });

        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({ scale: 1.5 });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = { canvasContext: ctx, viewport: viewport };
                page.render(renderContext).promise.then(function () {
                    pageRendering = false;
                    document.getElementById('page-num').textContent = num;
                });
            });
        }

        function prevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            renderPage(pageNum);
        }

        function nextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            renderPage(pageNum);
        }

    </script>
@endsection