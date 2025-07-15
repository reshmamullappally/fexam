<x-filament::page>
    <h5 class="text-xl font-bold mb-1">View Questions from PDF: {{ $record->name }}</h5>

    <div class="mb-1">
        <button onclick="prevPage()">Previous</button>
        <button onclick="nextPage()">Next</button>
        <span>Page: <span id="page-num">1</span> / <span id="page-count">--</span></span>
    </div>

    <canvas id="pdf-canvas" style="border: 1px solid #ddd; max-width: 100%;"></canvas>

    {{-- Load PDF.js --}}
    <script src="{{asset('js/pdf.min.js')}}"></script>

    <script>
        const url = "{{ asset('storage/'.$record->file_path) }}";
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
</x-filament::page>
