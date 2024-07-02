<?php
session_start();
include 'connection.php';
date_default_timezone_set('Asia/Manila');
$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];
$sessions = getSessionByEvent($event_id);
// $success = $_GET['success'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Demand Gen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body class="transition-colors duration-300 ease-in-out dark:bg-gray-800" id="body">
    
    <!-- Sidebar -->
    <?php include 'sidebar_tailwind.php'; ?>

    <!-- Events -->
    <section class="p-4 sm:ml-64">
        <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Event QR Scanner</h2>
        <!-- Start coding here -->
        <form id="qr-form" method="post">
            <input type="hidden" name="event_id" value="<?php echo $_GET['event_id']; ?>">
            <input class="form-control" id="scanned-data" type="text" name="scanned_data" placeholder="Scanned Data" readonly>
            <!-- Dropdown menu -->
            <div class="flex items-center justify-center m-10">
                <div class="relative">
                    <select name="dropdownSession"
                        class="block appearance-none w-full bg-white border border-gray-300 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:bg-white focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:focus:border-gray-500 dark:focus:ring-2 dark:focus:ring-gray-800">
                        <option value="0">Select Session</option>
                        <?php foreach ($sessions as $session): ?>
                        <option value="<?php echo $session['session_title']; ?>"><?php echo $session['session_title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M14.293 5.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L10 8.586l4.293-4.293z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Big Box -->
            <div class="flex items-center justify-center m-10">
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <video id="qr-video" width="800" height="600" autoplay playsinline></video>
                            <div id="qr-result" hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error or success messages - disappear in 3s -->
            <div id="message-container"></div>

            <!-- Name of Scanned QR Participant - disappear in 3s -->
            <div id="participant-container"></div>
        </form>
    </section>

    <script src="scanner.js"></script>
    <script>
        const video = document.getElementById('qr-video');
        const qrResult = document.getElementById('qr-result');
        const scannedDataInput = document.getElementById('scanned-data'); // Input field to display scanned data
        const messageContainer = document.getElementById('message-container');
        const participantContainer = document.getElementById('participant-container');

        const scanner = new Instascan.Scanner({ video: video });
        scanner.addListener('scan', function (content) {
            qrResult.innerText = content;

            // Update the input field with scanned data
            scannedDataInput.value = content;

            // Submit the form data using AJAX
            $.ajax({
                url: 'process_qr.php',
                method: 'POST',
                data: $('#qr-form').serialize(),
                success: function(response) {
                    // Clear previous messages and participant info
                    messageContainer.innerHTML = '';
                    participantContainer.innerHTML = '';

                    // Handle the response and update the message container
                    if (response.success) {
                        messageContainer.innerHTML = '<div class="flex justify-center mb-4">' +
                            '<div class="w-1/2 h-20 flex items-center justify-center mb-6 bg-transparent border-2 border-green-800 font-medium rounded-lg text-2xl px-3 py-1.5 text-center dark:text-green-400">' +
                            '<svg class="mr-4" height="50px" width="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#166534"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M8 12.3333L10.4615 15L16 9M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>' +
                            '<span class="text-green-800">Scanned</span>' +
                            '</div>' +
                            '</div>';

                        // Update participant name
                        participantContainer.innerHTML = '<div class="flex justify-center mb-4">' +
                            '<div class="w-1/2 h-20 flex items-center justify-center mb-6 bg-transparent border-2 border-blue-800 font-medium rounded-lg text-2xl px-3 py-1.5 text-center dark:text-blue-400">' +
                            '<svg class="mr-4" height="50px" width="50px" fill="#1e40af" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg" stroke="#1e40af"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 27.9999 26.6875 C 31.3983 26.7109 34.1171 23.8047 34.1171 19.9844 C 34.1171 16.4219 31.3983 13.4453 27.9999 13.4453 C 24.6014 13.4453 21.8827 16.4219 21.8827 19.9844 C 21.8827 23.8047 24.6014 26.6641 27.9999 26.6875 Z M 17.0780 39.9766 L 38.8983 39.9766 C 39.8358 39.9766 40.3046 39.3437 40.3046 38.5 C 40.3046 35.8750 36.3671 29.1016 27.9999 29.1016 C 19.6327 29.1016 15.6952 35.8750 15.6952 38.5 C 15.6952 39.3437 16.1640 39.9766 17.0780 39.9766 Z"></path></g></svg>' +
                            '<span class="text-blue-800">' + response.participantName + '</span>' +
                            '</div>' +
                            '</div>';
                    } else {
                        messageContainer.innerHTML = '<div class="flex justify-center mb-4">' +
                            '<div class="w-1/2 h-20 flex items-center justify-center mb-6 bg-transparent border-2 border-red-800 font-medium rounded-lg text-2xl px-3 py-1.5 text-center dark:text-red-400">' +
                            '<svg class="mr-4" height="50px" width="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#991b1b"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M9 9L15 15M15 9L9 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>' +
                            '<span class="text-red-800">' + response.message + '</span>' +
                            '</div>' +
                            '</div>';
                    }
                },
                error: function(err) {
                    console.error('Error submitting form:', err);
                    messageContainer.innerHTML = '<div id="error-message" class="text-red-500">Error submitting form. Please try again.</div>';
                }
            });

            setTimeout(function() {
                // Clear the scanned data input field after submission
                scannedDataInput.value = '';
                messageContainer.innerHTML = '';
                participantContainer.innerHTML = '';
            }, 3000);
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(err) {
            console.error('Error accessing camera:', err);
        });
    </script>
</body>
</html>

