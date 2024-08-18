<?php
    session_start();
    include 'connection.php';
    date_default_timezone_set('Asia/Manila');
    $user_id = $_SESSION['user_id'];
    $event_id = $_GET['event_id'];
    function getSessionTitle($connection, $event_id, $date, $time, $location) {
        // Convert the provided time to a DateTime object
        $timeObj = new DateTime($time);
        
        // Clone the time object for end time calculation
        $endTimeObj = clone $timeObj;
        
        // Add 2 hours for the end time
        $endTimeObj->modify('+2 hours');
        
        // Format the times back to strings
       // $startTime = "06:00";
        $attendTime = $timeObj;
        $endTime = $endTimeObj->format('H:i');
        
        
        // $strSql = "SELECT session_title FROM event_sessions 
        //            WHERE event_id = '$event_id' 
        //            AND date = '$date' 
        //            AND location1 = '$location' 
                //    AND (
                //        (timeam BETWEEN '$startTime' AND '$endTime') 
                //        OR 
                //        (timepm BETWEEN '$startTime' AND '$endTime')
                //    )";
        
        // $strSql = "SELECT session_title FROM event_sessions 
        // WHERE event_id = '$event_id' 
        // AND date = '$date' 
        // AND location1 = '$location'
        // AND (
        //                ('$startTime' BETWEEN timeam AND '$endTime') 
        //                OR 
        //                ( '$startTime' BETWEEN  timepm AND '$endTime')
        //            )";

        $strSql = "SELECT session_title FROM event_sessions 
        WHERE event_id = '$event_id' 
        AND date = '$date' 
        AND location1 = '$location'
        AND (
            ('$time' BETWEEN timeam AND ADDTIME(timeam, '02:00')) 
            OR 
            ('$time' BETWEEN timepm AND ADDTIME(timepm, '02:00')) 
        )";

        // $strSql = "SELECT session_title FROM event_sessions 
        // WHERE event_id = '$event_id' 
        // AND date = '$date' 
        // AND location1 = '$location'
        // AND timeam = '$attendTime'";

        $result = getRecord($connection, $strSql);
        return $result ? $result[0]['session_title'] : 'Unknown Session';
    }
    
    
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
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">WPS</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Timestamp</th>
                                <th scope="col" class="px-4 py-3">Session Title</th>
                                <th scope="col" class="px-4 py-3">Device ID</th>
                                <th scope="col" class="px-4 py-3">User ID</th>
                                <th scope="col" class="px-4 py-3">Location</th>
                                <th scope="col" class="px-4 py-3">Signal Strength (dBm)</th>
                                <th scope="col" class="px-4 py-3">Access Point ID</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $con = openConnection();
                            $strSql = "SELECT * FROM location WHERE event_id = '$event_id'";
                            $locations = getRecord($con, $strSql);

                            foreach ($locations as $location) {
                                // Split date and time
                                $dateTime = explode(' ', $location['date_and_time']);
                                $date = $dateTime[0];
                                $time = $dateTime[1];
                                
                                
                                // Get the session title using the modified function
                                $sessionTitle = getSessionTitle($con, $event_id, $date, $time, $location['location']);
                                
                                echo '<tr class="border-b dark:border-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $time.'</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $sessionTitle .'</th>
                                        <td class="px-4 py-3">'. $location['device_id'] .'</td>
                                        <td class="px-4 py-3">'. $location['user_id'] .'</td>
                                        <td class="px-4 py-3">'. $location['location'] .'</td>
                                        <td class="px-4 py-3">'. $location['signal_strength'] .'</td>
                                        <td class="px-4 py-3">'. $location['access_point'] .'</td>
                                        <td class="px-4 py-3">'. $location['action'] .'</td>
                                      </tr>';
                            }

                        ?>

                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <!-- <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
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
                </nav> -->
            </div>
        </section>

    </body>
</html>
