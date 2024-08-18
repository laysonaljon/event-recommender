<?php
    session_start();
    include 'connection.php';
    date_default_timezone_set('Asia/Manila');
    $user_id = $_SESSION['user_id'];
    $event_id = $_GET['event_id'];
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
            <h2 class="mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Events</h2>
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Full Name</th>
                                <th scope="col" class="px-4 py-3">Email</th>
                                <th scope="col" class="px-4 py-3">Company</th>
                                <th scope="col" class="px-4 py-3">Designation</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $con = openConnection();
                            $strSql = "SELECT * FROM participants WHERE event_id = '$event_id'";
                            $participants = getRecord($con, $strSql);
                            foreach($participants as $participant) {
                                echo '<tr class="border-b dark:border-gray-700">
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $participant['full_name'] .'</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $participant['email'] .'</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $participant['company'] .'</th>
                                        <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">'. $participant['designation'] .'</th>
                                        
                                ';
                                if($participant['status'] == 1){
                                    echo '<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">Answered</th>';
                                }
                                else{
                                    echo '<th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">Pending</th>';
                                }
                                echo'
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
