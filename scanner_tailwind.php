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
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Scanner</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Event Name</th>
                                <th scope="col" class="px-4 py-3">Number of Sessions</th>
                                <th scope="col" class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $con = openConnection();
                            $strSql = "SELECT * FROM events WHERE user_id = '$user_id' AND event_status != 0 ORDER BY event_id DESC";
                            $events = getRecord($con, $strSql);
                            foreach($events as $event) {
                                $event_id = $event['event_id'];
                                $totalCount = getTotalDistinctSessionTitlesByEvent($event_id);
                                echo '<tr class="border-b dark:border-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $event['event_title'] .'</th>
                                        <td class="px-4 py-3">'. $totalCount .'</td>
                                        <td class="px-4 py-3">
                                            <a href="event_qr_scanner_tailwind.php?event_id='.$event_id.'" class="w-full rounded-lg border border-blue-700 px-3 py-1 text-center text-sm font-medium text-blue-700 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-600 dark:hover:text-white dark:focus:ring-blue-900 lg:w-auto">Scanner</a>
                                        </td>
                                        
                                    </tr>

                                ';
                                
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </body>
</html>
