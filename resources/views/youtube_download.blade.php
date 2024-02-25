<!DOCTYPE html>
<html>

<head>
    <title>Youtube Downloader</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Download Videos</div>

                <div class="card-body">
                    <form id="searchForm">
                        @csrf
                        <div class="form-group">
                            <label for="searchQuery">Enter Video URL</label>
                            <input type="text" class="form-control" id="urlInput" value="https://www.youtube.com/watch?v=CH50zuS8DD0&t=2s" name="input_field" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div id="searchResults"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Handle form submission via AJAX
        $('#searchForm').submit(function(event) {
            event.preventDefault();
            var input = $('#urlInput').val();

            $.ajax({
                type: 'GET',
                url: '/download-youtube', // Adjust this based on your route setup
                data: {
                    input: input,
                },
                success: function(response) {
                    // Handle the response and display results
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>