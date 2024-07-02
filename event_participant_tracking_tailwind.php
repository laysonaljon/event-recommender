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
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Event Tracking</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

                <!-- TABLE -->
                <?php
                    $con = openConnection();
                    $strSql = "SELECT * FROM events WHERE user_id = '$user_id' and event_status != 0";
                    $events = getRecord($con, $strSql);
                    foreach ($events as $event) {
                        $event_id = $event['event_id']; ?>
                        <div class="mb-6">
                            <button id="toggleTable_<?php echo $event_id; ?>" class="w-full px-4 py-2 font-bold text-left text-gray-900 bg-gray-200 rounded dark:bg-gray-800 dark:text-white focus:outline-none">
                                <?php echo $event['event_title']; ?>
                                <span id="toggleIcon_<?php echo $event_id; ?>" class="float-right">▼</span>
                            </button>
                            <div id="collapsibleTable_<?php echo $event_id; ?>" class="overflow-x-auto mt-2 hidden">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Participant</th>
                                            <th scope="col" class="px-4 py-3">Session</th>
                                            <th scope="col" class="px-4 py-3">Date</th>
                                            <th scope="col" class="px-4 py-3">Time</th>
                                            <th scope="col" class="px-4 py-3">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            $sqlParticipants = "SELECT * FROM participants WHERE event_id = '$event_id'";
                                            $participants = getRecord($con, $sqlParticipants);

                                            foreach($participants as $participant) {
                                                $participant_id = $participant['participants_id'];
                                                $printedSessionTitles = [];

                                                $sqlDouble = "SELECT p.full_name, a.session_title AS session_title, p.participants_id, a.dateIn, a.timeIn, 'double' AS type 
                                                            FROM participants AS p
                                                            JOIN sesion_recommend AS sr ON sr.participants_id = p.participants_id 
                                                            JOIN attendance AS a ON a.participants_id = p.participants_id 
                                                            WHERE a.session_title = sr.session_title 
                                                            AND p.event_id = '$event_id' 
                                                            AND p.participants_id = '$participant_id'";
                                                $doubles = getRecord($con, $sqlDouble);

                                                $sqlRecommend = "SELECT p.full_name, sr.session_title AS session_title, p.participants_id, 'N/A' AS dateIn, 'N/A' AS timeIn, 'recommend' AS type 
                                                                FROM participants AS p
                                                                JOIN sesion_recommend AS sr ON sr.participants_id = p.participants_id 
                                                                AND p.event_id = '$event_id' 
                                                                AND p.participants_id = '$participant_id'";
                                                $recommends = getRecord($con, $sqlRecommend);

                                                $sqlAttend = "SELECT p.full_name, a.session_title AS session_title, p.participants_id, a.dateIn, a.timeIn, 'attend' AS type 
                                                            FROM participants AS p
                                                            JOIN attendance AS a ON a.participants_id = p.participants_id 
                                                            AND p.event_id = '$event_id' 
                                                            AND p.participants_id = '$participant_id'";
                                                $attends = getRecord($con, $sqlAttend);

                                                $combinedData = array_merge($doubles, $recommends, $attends);

                                                $namePrinted = false;
                                                foreach ($combinedData as $data) {
                                                    if (!in_array($data['session_title'], $printedSessionTitles)) {
                                                        echo '<tr class="border-b dark:border-gray-700">';
                                                        if (!$namePrinted) {
                                                            echo '<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white align-top py-6" rowspan="' . count($combinedData) . '">' . $participant['full_name'] . '</th>';
                                                            $namePrinted = true;
                                                        }
                                                        echo '<td class="px-4 py-3">' . $data['session_title'] . '</td>';
                                                        echo '<td class="px-4 py-3">' . $data['dateIn'] . '</td>';
                                                        echo '<td class="px-4 py-3">' . $data['timeIn'] . '</td>';
                                                        echo '<td class="px-4 py-3">';
                                                        echo '<div class="absolute right-0 top-7 content-center sm:relative sm:right-auto sm:top-auto">';
                                                        if ($data['type'] == 'recommend' || $data['type'] == 'double') {
                                                            echo '<span class="inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z" />
                                                                    </svg>
                                                                    Recommended
                                                                </span>';
                                                        }
                                                        if ($data['type'] == 'attend' || $data['type'] == 'double') {
                                                            echo '<span class="inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                                                    <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                                                    </svg>
                                                                    Attended
                                                                </span>';
                                                        }
                                                        echo '</div>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                        $printedSessionTitles[] = $data['session_title'];
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </table>
                            </div>
                        </div>
                <?php    
                    }
                ?>
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
