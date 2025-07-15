<!DOCTYPE html>
<html lang="en">
<head>
        @include('front-end.includes.head')
</head>
<body>
    <header class="fixed w-full">
       @include('front-end.includes.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800">
        @include('front-end.includes.footer')
    </footer>
</body>
</html>
