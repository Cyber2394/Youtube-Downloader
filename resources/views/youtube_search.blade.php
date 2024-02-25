@extends('layouts.app')
@extends('index_styles')
@section('content')

<!DOCTYPE html>
<html>

<head>
    <title>Youtube Search Query</title>
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
                <div class="card-header">Search Videos</div>
                <div class="card-body">
                    <form id="searchForm">
                        @csrf
                        <div class="form-group">
                            <label for="searchQuery">Search Query</label>
                            <input type="text" class="form-control" id="searchQuery" value="lucky 8th day audio,Bueh Bueh audio" name="search_query" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <div id="downloadAllButtonPlacement">
                        <!-- <button onclick="downloadall('IkE1zg8gNoU,XpM02D7Mrws');" type="submit" style="margin-left: 85%;" class="btn btn-primary">Download All</button> -->
                    </div>
                    <div id="searchResults"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function downloadall(allIds) {
        console.log(allIds)
        $.ajax({
            type: 'GET',
            url: '/download-youtube-all',
            data: {
                allIds: allIds,
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function download(id) {
        console.log("In Download Function");
        var input = id;
        $.ajax({
            type: 'GET',
            url: '/download-youtube',
            data: {
                input: input,
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#searchForm').submit(function(event) {
            event.preventDefault();

            var input = $('#searchQuery').val();
            var allIds = [];

            $.ajax({
                type: 'POST',
                url: '/search-videos',
                data: {
                    input: input,
                },
                success: function(response) {
                    console.log(response);

                    response.forEach(function(item) {
                        let videoName = item.videoName;
                        let videoId = item.videoId;

                        let resultsHtml = '<ul class="list-group">' +
                            '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                            videoName +
                            '<button class="btn btn-primary" onclick="download(\'' + videoId + '\');" id="' + videoId + '">Download</button>' +
                            '</li>' +
                            '</ul>';
                        $('#searchResults').append(resultsHtml);
                        allIds.push(videoId);
                    });
                    // console.log(allIds);
                    let downloadAllButton = '<button onclick="downloadall(\'' + allIds + '\');" type="submit" style="margin-left: 85%;" class="btn btn-primary" >Download All</button>'

                    $('#downloadAllButtonPlacement').html(downloadAllButton);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });



            //////////////////////////////////////////////////////////////////////////////////
            if (input == "test") {
                var items = input.split(',');
                var totalItems = items.length;
                var itemsProcessed = 0;
                var allIds = [];

                function processNextItem(index) {
                    if (index < totalItems) {
                        $('#loading-icon').show();
                        console.log(`Processing item ${index + 1} of ${totalItems}`);

                        $.ajax({
                            type: 'POST',
                            url: '/search-videos',
                            data: {
                                input: items[index],
                            },
                            success: function(response) {
                                console.log(response);
                                let videoId = response.videoId;
                                let videoName = response.videoName;
                                let resultsHtml = '<ul class="list-group">' +
                                    '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    videoName +
                                    '<button class="btn btn-primary" onclick="download(\'' + videoId + '\');" id="' + videoId + '">Download</button>' +
                                    '</li>' +
                                    '</ul>';
                                $('#searchResults').append(resultsHtml);
                                allIds.push(videoId);
                                // console.log(allIds);

                                let downloadAllButton = '<button onclick="downloadall(\'' + allIds + '\');" type="submit" style="margin-left: 85%;" class="btn btn-primary" >Download All</button>'

                                $('#downloadAllButtonPlacement').html(downloadAllButton);

                                itemsProcessed++;
                                if (itemsProcessed === totalItems) {
                                    $('#loading-icon').hide();
                                }

                                processNextItem(index + 1);
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                                processNextItem(index + 1);
                            }
                        });
                    }
                }

                processNextItem(0);
            }
        });
    });
</script>
@endsection