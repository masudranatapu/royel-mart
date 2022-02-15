<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
        @php
            $website = App\Models\Website::latest()->first();
        @endphp
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{$website->favicon}}">
        <!-- all css here -->
        @yield('meta')
        <!-- for header link -->
        @include('layouts.frontend.partial.head')
        <link rel="stylesheet" href="{{asset('massage/toastr/toastr.css')}}">
        <!-- for css input -->
        @stack('css')
    </head>
    <body>
        @include('layouts.frontend.partial.header')
        @yield('content')
        <div class="overlay"></div>
        <button class="scrollTop"><i class="bi bi-chevron-up"></i></button>
        @include('layouts.frontend.partial.footer')
        @include('layouts.frontend.partial.foot')

        <script src="{{asset('massage/toastr/toastr.js')}}"></script>
        {!! Toastr::message() !!}
        <script>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastr.error('{{ $error }}','Error',{
                        closeButton:true,
                        progressBar:true,
                    });
                @endforeach
            @endif
        </script>
        @stack('js')
    </body>
</html>