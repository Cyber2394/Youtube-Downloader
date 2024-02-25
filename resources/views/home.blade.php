@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <style>
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            position: sticky;
            top: 0;
        }

        .table-condensed {
            font-size: 12px !important;
            font-weight: normal !important;
        }

        th {
            background: rgb(32, 51, 63);
            color: white;
            height: 20px;
            font-weight: 100;
            text-align: left;
        }

        thead {
            background: rgb(32, 51, 63);
            color: black;
            height: 20px;
            font-weight: 200;
            text-align: left;
        }

        .table-wrapper {
            border: 1px solid rgb(221, 221, 221);
            overflow: auto;
            flex-grow: 1;
            width: 100%;
            background-color: #f6f8fa;
            display: flex;
            flex-direction: column;
        }

        body {
            height: 100%;
            margin: 0;
        }

        .header {
            position: sticky;
            top: 0;
        }

        .btn-primary {
            background-color: #20333f !important;
            border-color: #20333f !important;
        }

        table {
            border: 1px solid black;
            margin-right: 20px;
            border-spacing: 0px;
        }

        .loading-icon {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body style="background-color: #28343c;">

</body>
<div class="container" style="max-width: 100%;">
    <!-- Adjust the max-width and background-color values as needed -->
    <div class="row justify-content-center">
        <div class="col-md-12 pl-5 pr-5">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div style="background-color:#f7f7f7; border: 1px solid #c9cbcb" class="card-body pb-0">
                    <form id="asyncForm" name="asyncForm" onsubmit="return false">
                        <div class="form-group">
                            <div class="col-12 m-0">
                                <div class="input-group mb-3">
                                    <input id='dataInput' value="John" name="member" type="text" class="form-control mr-3" placeholder="Enter username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <select id="inputState" class="form-control">
                                            <option value="playlist-create">Create New Playlist</option>
                                            <option value="playlist-get">Get User's Playlists</option>
                                            <option value="spotify">Search Song From Spotify</option>
                                            <option value="ytDownload">Download Youtube Video</option>
                                            <option value="chat">ChatGPT(WIP)</option>
                                            <option selected>Search User By UserName</option>
                                            <option>Search User By Email</option>
                                            <option>Search User By Id</option>
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
                        <div class="loading-icon" id="loading-icon"></div>
                    </div>
                    <button style="display: none; margin-bottom: 10px" id="download" onclick="window.location=''" class="btn btn-info btn-sm">
                        <i class="fas fa-download"></i>&nbsp Download
                    </button>
                </div>

                <div id="scroller" class="table-wrapper">

                    <table id="displayTable" class="table table-bordered data-table table-striped">
                        <thead id="tableHead" style="position: sticky;">
                        </thead>
                        <tbody id="tableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</html>
@endsection