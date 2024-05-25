<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hotel Booking</title>
        {{-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> --}}
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-RE3t+uPxbvY3AI2zIh+WLgJGjdFfzskZGv1EfeN/zOZ2RCwo/6JgVWAz4FzDOdiYMXqah7kp5PU+Trp6fdk3OQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <style>
        body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
        .notification-container {
                max-height: 300px; /* Adjust the height as needed */
                overflow-y: auto;
            }
        </style>
    </head>
    <body class="w3-light-grey">


        <!-- Navigation Bar -->
       
        @include('user.layouts.navigation')

         @yield('content')
           
    </body>
        <script>
            $(document).ready(function() {
                $(".notification-drop .item").on('click',function() {
                    $(this).find('ul').toggle();
                });
                // });
                // $('body').bind('cut copy paste', function (e) {

                //     e.preventDefault();

                // });

                //     //Disable mouse right click
                // $("body").on("contextmenu",function(e){
                //     return false;
                });
    </script>
        {{-- <script src="//code.tidio.co/farqgtymgcauexocew8wuah5s44cppgw.js" async></script> --}}

    </html>