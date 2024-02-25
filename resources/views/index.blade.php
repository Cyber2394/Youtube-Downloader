@extends('layouts.app')
@extends('index_styles')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lab</title>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="background-color: #28343c;">

</body>
<div class="container" style="max-width: 80%;">
    <div class="row justify-content-center">
        <div class="col-md-12 pl-5 pr-5">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div style="background-color:#f7f7f7; border: 1px solid #c9cbcb" class="card-body pb-0">
                    <form id="asyncForm" name="asyncForm" onsubmit="return false">
                        <div class="form-group">
                            <div class="col-12 m-0">
                                <div class="input-group mb-3">
                                    <input id='dataInput' value="Bret" name="member" type="text" class="form-control mr-3" placeholder="Enter username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <select id="inputState" class="form-control">
                                            <option>Search User By UserName (API)</option>
                                            <option>Search User By Email (API)</option>
                                            <option>Search User By Id (API)</option>
                                            <option>Search for Image</option>
                                            <option>Search Song From Spotify</option>
                                            <option>Delete User</option>
                                            <option>Search User By Email</option>
                                            <option>Search User By Id</option>
                                            <option>Create Fake User</option>
                                            <option selected>Chat GPT</option>
                                        </select>
                                    </div>
                                    <div class="input-group-append">
                                        <button id="asyncBtn" class="btn btn-primary" id="search-addon">
                                            <i class="fas fa-arrow-alt-circle-right"></i>&nbsp Submit
                                        </button>
                                    </div>
                                    &nbsp&nbsp
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="response">
                        <div class="loading-icon" id="loading-icon" hidden></div>
                    </div>
                    <button style="display: none; margin-bottom: 10px" id="download" onclick="window.location=''" class="btn btn-info btn-sm">
                        <i class="fas fa-download"></i>&nbsp Download
                    </button>
                </div>
                <!-- text box for chat gpt -->
                <div class="container" id="chat-container">
                    <div class="fixed-bottom  chat-text-box">
                        <div class="form-group ">
                            <div class="input-group">
                                <input class="form-control" id="chat-input" placeholder="Send A Message..."></input>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="chat-submit" type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -------- -->



                <input type="hidden" value="false" id="convo-check">

                <div id="scroller" class="table-wrapper">
                    <div class="d-flex justify-content-center align-items-center">
                        <ul id="spotify-search-result" class="list-group ">
                        </ul>
                    </div>
                    <div id="imageContainer" class="image-container"></div>
                    <!-- Chat container -->
                    <div class="container" id="chat">

                    </div>
                    <table id="displayTable" class="table table-bordered data-table table-striped">
                        <thead id="tableHead" style="position: sticky;">
                        </thead>
                        <tbody id="tableBody">
                        </tbody>
                    </table>
                </div>
                <table id="dynamicTable" class="table table-striped">
                    <thead></thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

</html>

<script>
    $(document).ready(function() {
        $('#chat-input').keypress(function(event) {
            // Check if the Enter key is pressed (key code 13)
            if (event.keyCode === 13) {
                // Prevent the default behavior of the Enter key (i.e., submitting the form)
                event.preventDefault();

                // Trigger a click event on the send button
                $('#chat-submit').click();
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $('#inputState').change(function() {
        var inputState = $(this).val();
        console.log('Option changed to:', inputState);
        if (inputState !== "Create Fake User") {
            $('#dataInput').attr('type', 'text');
        }
        if (inputState == "Search User By UserName (API)") {
            $('#dataInput').attr('placeholder', 'Enter UserName');
        }
        if (inputState == "Search User By Email (API)") {
            $('#dataInput').attr('placeholder', 'Enter Email');
        }
        if (inputState == "Search User By Id (API)") {
            $('#dataInput').attr('placeholder', 'Enter Id');
        }
        if (inputState == "Search for Image") {
            $('#dataInput').attr('placeholder', 'Search for Image');
        }
        if (inputState == "Delete User") {
            $('#dataInput').attr('placeholder', 'Enter Email');
        }
        if (inputState == "Search User By Email") {
            $('#dataInput').attr('placeholder', 'Enter Email');
        }
        if (inputState == "Search User By Id") {
            $('#dataInput').attr('placeholder', 'Enter Id');
        }
        if (inputState == "Create Fake User") {
            $('#dataInput').attr('placeholder', 'Enter Amount of Users');
            $('#dataInput').attr('type', 'number');
        }
        if (inputState == "Search Song From Spotify") {
            $('#dataInput').attr('placeholder', 'Enter Song Name');
        }
        if (inputState == "Chat GPT") {
            $('#dataInput').attr('placeholder', 'Send A Message');
            $('#chat-container').show()
        }
        if (inputState == "Chat GPT") {
            $('#dataInput').attr('placeholder', 'Send A Message');
            $('#chat-container').show()
        }else{
            $('#chat-container').hide()
        }
    });

    function displayUsers(response, currentIndex, totalLength) {
        $('#scroller').show();
        $('#displayPre').hide();
        var variableNames = Object.keys(response[0]);
        var thead = '';
        if (variableNames.length > 0) {
            thead += '<th style="background: rgb(32, 51, 63); color: white;" class="header counter-cell">#</th>';
            thead += '<th style="background: rgb(32, 51, 63); color: white;" class="header">' + variableNames[0] + '</th>';
        }

        $.each(variableNames, function(innerIndex, title) {
            if (innerIndex > 0) {
                thead += '<th style="background: rgb(32, 51, 63); color: white;" class="header">' + title + '</th>';
            }
        });

        var tbody = '';
        $.each(response, function(innerIndex, items) {
            tbody += '<tr>';
            tbody += '<td class="counter-cell">' + (currentIndex) + '/' + totalLength + '</td>';
            $.each(variableNames, function(innerIndex, title) {
                tbody += '<td>' + items[title] + '</td>';
            });
            tbody += '</tr>';
        });

        $('#json-output').hide();
        $('#scroller').scrollTop($('#scroller')[0].scrollHeight);
        $('#tableHead').html(thead);
        $('#tableBody').append(tbody);
    }

    function searchSpotify(response) {
        $('#loading-icon').hide();
        var result = '';

        console.log(response);

        $.each(response, function(index, track) {
            result += '<li class="list-group-item">' +
                '<div class="iframe-container">' +
                '<iframe src="https://open.spotify.com/embed/track/' + track.id + '" width="600" height="80" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
        });

        $('#spotify-search-result').html(result);

        console.log(response);
    }

    $('#asyncBtn').click(function(event) {
        var scrollerHtml =
            '<div id="scroller" class="table-wrapper">' +
            '<div class="d-flex justify-content-center align-items-center">' +
            '<ul id="spotify-search-result" class="list-group "></ul>' +
            '</div>' +
            '<div id="imageContainer" class="image-container"></div>' +
            '<div class="container" id="chat"> ' +
            '</div>' +
            '<table id="displayTable" class="table table-bordered data-table table-striped">' +
            '<thead id="tableHead" style="position: sticky;"></thead>' +
            '<tbody id="tableBody"></tbody>' +
            '</table>' +
            '</div>';

        $('#scroller').html(scrollerHtml);

        $('#tableHead').html("");
        $('#tableBody').html("");
        $('#chat').html("");

        $('#loading-icon').show();

        var inputState = $('#inputState').val()
        var dataInput = $('#dataInput').val()

        console.log("async Btn has been clicked")
        console.log(inputState, dataInput)

        if (inputState == "Search for Image") {

            $.ajax({
                url: '/unsplash/search',
                type: 'get',
                data: {
                    input: dataInput
                },
                success: function(response) {
                    $('#imageContainer').empty();
                    const img = $('<img>').addClass('img-fluid rounded shadow').attr('src', response.image.urls.small).attr('alt', response.image.alt_description);
                    const container = $('<div>').addClass('text-center image-container');
                    container.append(img);
                    $('#imageContainer').append(container);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        if (inputState == "Search User By UserName (API)") {
            var items = dataInput.split(' ');
            var totalItems = items.length;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);

                    $.ajax({
                        url: '/search-user-api/username',
                        type: 'get',
                        data: {
                            input: items[index],
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
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

        if (inputState == "Search User By Email (API)") {
            var items = dataInput.split(' ');
            var totalItems = items.length;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);

                    $.ajax({
                        url: '/search-user-api/email',
                        type: 'get',
                        data: {
                            input: items[index],
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
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

        if (inputState == "Search User By Id (API)") {
            var items = dataInput.split(' ');
            var totalItems = items.length;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);

                    $.ajax({
                        url: '/search-user-api/id',
                        type: 'get',
                        data: {
                            input: items[index],
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
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

        if (inputState == "Delete User") {
            var items = dataInput.split(' ');
            var totalItems = items.length;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);

                    $.ajax({
                        url: '/user/delete',
                        type: 'get',
                        data: {
                            input: items[index],
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
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

        if (inputState == "Search User By Email") {
            var items = dataInput.split(' ');
            var totalItems = items.length;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);

                    $.ajax({
                        url: '/user/search/email',
                        type: 'get',
                        data: {
                            input: items[index],
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
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

        if (inputState == "Search User By Id") {
            var items = dataInput.split(' ');
            var totalItems = items.length;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);

                    $.ajax({
                        url: '/user/search/id',
                        type: 'get',
                        data: {
                            input: items[index],
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
                            itemsProcessed++;
                            if (itemsProcessed === totalItems) {
                                $('#loading-icon').hide();
                            }

                            processNextItem(index + 1); // Process the next item
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            processNextItem(index + 1); // Move to the next item even if an error occurs
                        }
                    });
                }
            }

            processNextItem(0);
        }

        if (inputState == "Create Fake User") {
            var totalItems = dataInput;
            var itemsProcessed = 0;

            function processNextItem(index) {
                if (index < totalItems) {
                    $('#loading-icon').show();
                    console.log(`Processing item ${index + 1} of ${totalItems}`);
                    $.ajax({
                        url: '/user/create-fake-user',
                        type: 'get',
                        data: {
                            input: dataInput,
                        },
                        success: function(response) {
                            displayUsers(response, index + 1, totalItems);
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

        if (inputState == "Create User") {
            $.ajax({
                url: '/user/create-fake-user',
                type: 'GET',
                data: {
                    input: dataInput
                },
                success: function(response) {
                    searchSpotify(response)
                    console.log(response)
                },
                error: function(xhr) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        }

        if (inputState == "Search Song From Spotify") {
            $.ajax({
                url: '/spotify/search',
                type: 'GET',
                data: {
                    input: dataInput
                },
                success: function(response) {
                    searchSpotify(response)
                    console.log(response)
                },
                error: function(xhr) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        }
    });

    $('#chat-submit').click(function(event) {
        event.preventDefault();
        var scrollerHtml =
            '<div id="scroller" class="table-wrapper">' +
            '<div class="d-flex justify-content-center align-items-center">' +
            '<ul id="spotify-search-result" class="list-group "></ul>' +
            '</div>' +
            '<div id="imageContainer" class="image-container"></div>' +
            '<div class="container" id="chat"> ' +
            '</div>' +
            '<table id="displayTable" class="table table-bordered data-table table-striped">' +
            '<thead id="tableHead" style="position: sticky;"></thead>' +
            '<tbody id="tableBody"></tbody>' +
            '</table>' +
            '</div>';

        $('#scroller').html(scrollerHtml);

        $('#tableHead').html("");
        $('#tableBody').html("");
        $('#chat').html("");

        $('#loading-icon').show();

        var element = $('#convo-check').val();
        var input = $('#chat-input').val();

        if (element == "false") {

            conversationHistory = [];
            conversationHistory.push({
                'role': 'user',
                'content': input
            });

            console.log("undifined");
        } else if (element !== "false") {
            conversationHistory.push({

                'role': 'user',
                'content': input
            });

            console.log("defined");

        }

        $.ajax({
            url: '/chat',
            type: 'POST',
            data: ({
                input: input,
                conversationHistory: conversationHistory
            }),

            success: function(response) {
                var chat = '';
                var chatGPTResult = '';
                console.log(response.conversationHistory);

                chat +=
                    '<div class="row">' +
                    '<div class="col-6">' +
                    '<div class="bubble bubble-user-a">' +
                    '<p>Human: ' + response.user + '</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-6 offset-6">' +
                    '<div class="bubble bubble-user-b">' +
                    '<p>ChatGPT: ' + response.message + '</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                var chatDiv = $('#chat');
                $('#chat').append(chat);
                $('#scroller').animate({ scrollTop: $('#scroller')[0].scrollHeight }, 'slow');

                $('#chat-input').val('');

                $('#convo-check').val(response.user);


            },
            error: function(xhr) {
                // Handle the error response
                console.log(xhr.responseText);
            }
        });

    });
</script>
@endsection