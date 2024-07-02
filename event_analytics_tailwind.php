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
                    <div class="w-full px-4 py-2 font-bold text-left text-gray-900 bg-gray-200 rounded dark:bg-gray-800 dark:text-white focus:outline-none">
                        <span><?php echo $event_title; ?></span>
                        <span class="toggleTable" type="button" class="float-right">▼</span>
                    </div>
                    <div id="collapsibleTable" class="overflow-x-auto mt-2 hidden">
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
                <!-- PAGINATION -->
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                    </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </body>
</html>