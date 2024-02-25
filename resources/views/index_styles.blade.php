<head>
    <style>
        .image-container {
            margin-top: 20px;
            /* Add a slight margin from the top */
        }

        .adjustable-element {
            height: 100vh;
            background-color: #f1f1f1;
        }

        .separator {
            margin: 0px;
            border-top: 1px solid #666;
            padding: 0;
        }

        .header {
            position: sticky;
            top: 0;
        }

        .loader {
            margin-top: 5px;
            border: 6px solid #0b8cc8;
            /* border-radius: 10%; */
            width: 18px;
            height: 18px;
            -webkit-animation: spin .9s linear infinite;
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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
            overflow-x: hidden;
            top: 0;
            left: 0;
            height: 65vh;
            width: 100%;
            background-color: #f6f8fa
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

        td {
            background-color: rgb(255, 255, 255);
            word-break: normal !important;
            font-size: 14px !important;
        }

        pre {
            outline: 1px solid #ccc;
            padding: 5px;
            margin: 35px;
            padding: 10px;
            border-radius: 4px;
            font-family: Consolas, monospace;
            font-size: 12px;
        }

        .string {
            color: #555;
        }

        .number {
            color: red;
        }

        .boolean {
            color: #07a;
        }

        .null {
            color: rgb(207, 111, 21);
        }

        .key {
            color: rgb(28, 104, 174);
            ;
            font-weight: bold;
        }

        .btn:hover .fas {
            color: cyan !important;
            transition: all 0.3s ease 0s;
        }

        .btn:hover .fa-power-off {
            color: rgb(240, 90, 16) !important;
            transition: all 0.3s ease 0s;
        }

        pre {
            white-space: pre-wrap;
            white-space: -moz-pre-wrap;
            white-space: -pre-wrap;
            white-space: -o-pre-wrap;
            word-wrap: break-word;
        }

        .code-block {
            background-color: #2b2b2b;
            color: white;
            padding: 5px;
            margin: 0px;
            font-family: monospace;
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

        .counter-cell {
            font-weight: bold;
        }

        .text-hidden {
            position: absolute;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            width: 1px;
            height: 1px;
        }

        .play-circle {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: transform 0.1s ease-in-out;
        }

        .play-circle:hover {
            transform: scale(1.2);
            /* Adjust the scale factor as desired */
        }

        .playlist-name:hover {
            text-decoration: underline;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            display: none;
            position: absolute;
            min-width: 160px;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        input:autofill {
            background: #fff;
            /* or any other */
        }

        .chat-text-box {
            margin-bottom: 2%;
            max-width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .bubble {
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .bubble-user-a {
            background-color: #eaeaea;
        }

        .bubble-user-b {
            background-color: #d4edf7;
        }
    </style>

</head>