
      @extends('layouts.app')
        <!-- <div class="flex-center position-ref full-height"> -->
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif -->
            @section('content')

            <div class="content">
                <div class="title m-b-md">
                    <b>Ed</b>-Net
                </div>

                <div class="">
                  <p class='lead'>A social network for teachers and students</p>
                </div>

                <div class="links">
                    <a href="/">About</a>
                    <a href="/">Contact</a>
                    <a href="/">Github</a>
                </div>
            </div>
            @endsection
        <!-- </div> -->
