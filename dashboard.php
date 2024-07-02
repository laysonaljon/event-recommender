<?php

session_start();
include 'connection.php';
$user_id = $_SESSION['user_id'];
$eventCount = getEventCountByUser($user_id);
$totalDistinctSessions = getTotalDistinctSessionTitlesByUser($user_id);
$totalDistinctSpeakers = getTotalDistinctSpeakersByUser($user_id);
$totalDistinctParticipants = getTotalDistinctParticipantsByUser($user_id);


?>
<!DOCTYPE>
<html>
    <head>
        <title>Dashboard</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/tailwind.config.js"></script>
    </head>
        
    </head>
   
    <body class="transition-colors duration-300 ease-in-out dark:bg-gray-800" id="body">
        
        <!-- Sidebar -->
        <?php include 'sidebar_tailwind.php'; ?>
        
        <!-- Dashboard -->
        <div class="p-4 sm:ml-64 ">
           
            <div class="flex items-center justify-center h-48 mb-4 rounded bg-blue-200">
                <div class="text-xl text-blue-800">
                    <?php echo $eventCount; ?> Events
                </div>
            </div>
            
            <div class="flex items-center justify-center h-48 mb-4 rounded bg-red-200">
                <div class="text-xl text-red-800">
                    <?php echo $totalDistinctSessions; ?> Sessions
                </div>
            </div>
            
            <div class="flex items-center justify-center h-48 mb-4 rounded bg-green-200">
                <div class="text-xl text-green-800">
                    <?php echo $totalDistinctSpeakers; ?> Speakers
                </div>
            </div>
            
            <div class="flex items-center justify-center h-48 mb-4 rounded bg-blue-200">
                <div class="text-xl text-blue-800">
                <?php echo $totalDistinctParticipants; ?> Participants
                </div>
            </div>

        </div>

    </body>
</html>
