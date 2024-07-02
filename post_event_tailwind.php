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
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Post Event</h2>
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

                        <div class="collapsibleTable overflow-x-auto mt-2 hidden">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">Participant</th>
                                        <th scope="col" class="px-4 py-3">Attended Sessions</th>
                                        <th scope="col" class="px-4 py-3">Recommended Products</th>
                                        <th scope="col" class="px-4 py-3">Comments</th>
                                        <th scope="col" class="px-4 py-3">Suggestions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $participants = getParticipantsByEvent($event_id);
                                    foreach ($participants as $participant) {
                                        $participant_id = $participant['participants_id'];
                                        $email = $participant['email'];
                                    ?>
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3"><?php echo $participant['full_name'] ?></td>
                                        <!-- Attended Sessions -->
                                        <td class="px-4 py-3">
                                            <!-- Session 1 -->
                                            <?php
                                                $attendances = getParticipantAttendance($participant_id, $event_id);

                                                // Check if $attendances is not empty
                                                if (!empty($attendances)) {
                                                    foreach($attendances as $attendance) {
                                                        echo '
                                                            <span class="inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                                                                ' . $attendance['session_title'] . '
                                                            </span>';
                                                    }
                                                } else {
                                                    // Handle case where no attendance details are found
                                                    echo '<span>No attendance details found.</span>';
                                                }
                                            ?>
                                        </td>
                                        <!-- Recommended Products -->
                                        <td class="px-4 py-3">
                                        <?php
                                                $products = getProductByUser($email, $event_id);

                                                // Check if $products is not empty
                                                if (!empty($products)) {
                                                    foreach($products as $product) {
                                                        echo '
                                                            <span class="inline-flex items-center rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                                '.$product['product_name'].'
                                                            </span>';
                                                    }
                                                } else {
                                                    // Handle case where no attendance details are found
                                                    echo '<span>No Product details found.</span>';
                                                }
                                            ?>
                                        </td>
                                        <?php
                                                $comments = getCommentByUser($email, $event_id);

                                                // Check if $comments is not empty
                                                if (!empty($comments)) {
                                                    foreach($comments as $comment) {
                                                        echo '
                                                                <td class="px-4 py-3">'.$comment['comment'].'</td>
                                                                <td class="px-4 py-3">'.$comment['suggestion'].'</td>
                                                            ';
                                                    }
                                                } else {
                                                    // Handle case where no attendance details are found
                                                    echo '<span>No Product details found.</span>';
                                                }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </section>
    </body>
</html>
