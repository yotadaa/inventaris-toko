<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- Styles -->

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- Add this to your blade view file -->
    <form id="myForm">
        <!-- Your form fields go here -->
        <input type="text" name="field_name" id="field_name">
        <!-- Other form fields -->

        <button type="button" onclick="submitForm()">Submit</button>
    </form>
    <div id='text'></div>

    <script>
        function submitForm() {
            $.ajax({
                url: '/submitForm',
                type: 'POST',
                data: $('#myForm').serialize(),
                success: function(response) {
                    console.log(response);
                    document.querySelector('#text').textContent = response.value
                    // Handle the response here
                },
                error: function(error) {
                    console.error(error);
                    // Handle errors here
                }
            });
        }
    </script>
</body>

</html>
