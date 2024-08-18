<?php 
session_start();
include 'connection.php';
date_default_timezone_set('Asia/Manila');
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE>
<html>
    <head>
        <title>Demand Gen</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/tailwind.config.js"></script>
    </head>
        
    </head>
   
    <body class="transition-colors duration-300 ease-in-out dark:bg-gray-800" id="body">
        
        <!-- Sidebar -->
        <?php include 'sidebar_tailwind.php'; ?>
        
        <!-- Events -->
        <section class="p-4 sm:ml-64 ">
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Event Analytics</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                
                <!-- TABLE -->
                <?php
                $con = openConnection();
                $strSql = "SELECT * FROM events WHERE user_id = '$user_id' AND event_status != 0 ORDER BY event_id DESC";
                $events = getRecord($con, $strSql);
                ?>

                <script>
                    // Wait for DOM content to load
                    document.addEventListener('DOMContentLoaded', function() {
                        // Get all toggle buttons and attach click event listener
                        const toggleButtons = document.querySelectorAll('.toggleTable');
                        toggleButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const table = this.parentNode.nextElementSibling;
                                const icon = this;
                                if (table.classList.contains('hidden')) {
                                    table.classList.remove('hidden');
                                    icon.textContent = '▲';
                                } else {
                                    table.classList.add('hidden');
                                    icon.textContent = '▼';
                                }
                            });
                        });
                    });
                </script>

                <?php foreach ($events as $event) {
                    $event_id = $event['event_id'];
                    $event_title = $event['event_title'];
                 
                
                ?>
                <div class="mb-6">
                <div class="mb-6">
                    <button id="toggleTable_<?php echo $event_id; ?>" class="w-full px-4 py-2 font-bold text-left text-gray-900 bg-gray-200 rounded dark:bg-gray-800 dark:text-white focus:outline-none">
                        <?php echo $event['event_title']; ?>
                        <span id="toggleIcon_<?php echo $event_id; ?>" class="float-right">▼</span>
                    </button>
                    <div id="collapsibleTable_<?php echo $event_id; ?>" class="overflow-x-auto mt-2 hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Session</th>
                                        <th scope="col" class="px-4 py-3 flex items-center">
                                            <span class="flex items-center mr-4">
                                              <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                              Expected
                                            </span>
                                            <span class="flex items-center">
                                              <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                              Attended
                                            </span>
                                          </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $event_sessions = getSessionByEvent($event_id);
                                        foreach($event_sessions as $event_session) {
                                            $session_title = $event_session['session_title'];
                                            $attendanceCount = getAttendanceCountBySession($session_title, $event_id);
                                            $attendanceWidth = $attendanceCount * 5;
                                            $recommendedCount = getRecommendedSessionCount($session_title, $event_id);
                                            $recommendedWidth = $recommendedCount * 5;
                                            echo '<tr>
                                                    <td class="px-4 py-3">'.$event_session['session_title'].'</td>
                                                    <td class="px-4 py-3">
                                                    <!-- Expected Bar -->

                                                    <div class="flex items-center mt-4">
                                                        <span class="mr-2">'.$recommendedCount.'</span>
                                                        <div class="relative w-full h-4">
                                                        <div class="absolute top-0 left-0 h-full bg-blue-500" style="width: '. $recommendedWidth .'%;"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Attended Bar -->

                                                    <div class="flex items-center mt-4">
                                                        <span class="mr-2">'.$attendanceCount.'</span>
                                                        <div class="relative w-full h-4">
                                                        <div class="absolute top-0 left-0 h-full bg-green-500" style="width: '. $attendanceWidth .'%;"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                </tr>';
                                        }
                                    ?>
                                    <!-- Event 1 -->
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
    </body>
    <script>
        document.querySelectorAll('button[id^="toggleTable_"]').forEach(function(button) {
            button.addEventListener('click', function() {
                const eventId = button.id.split('_')[1];
                const table = document.getElementById('collapsibleTable_' + eventId);
                const icon = document.getElementById('toggleIcon_' + eventId);
                if (table.classList.contains('hidden')) {
                    table.classList.remove('hidden');
                    icon.textContent = '▲';
                } else {
                    table.classList.add('hidden');
                    icon.textContent = '▼';
                }
            });
        });
    </script>
</html>