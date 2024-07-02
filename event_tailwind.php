<?php
    session_start();
    include 'connection.php';
    date_default_timezone_set('Asia/Manila');
    $user_id = $_SESSION['user_id'];

    // Function to get event session titles, dates, and times for a specific event
    function getEventSessionsInfo($connection, $event_id) {
        $sessionsInfo = array();
        $sql = "SELECT DISTINCT session_title, date, timeam, timepm, event_id FROM event_sessions WHERE event_id = '$event_id'";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $sessionsInfo[] = $row;
            }
        }
        return $sessionsInfo;
    }
?>
<!DOCTYPE>
<html>
    <head>
        <title>Demand Gen</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="/tailwind.config.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
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

            <!-- Delete Confirmation Modal -->
            <form method="post">
                <div id="deleteModalEvent" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                        <p class="text-xl font-semibold text-gray-800 mb-4">Confirm Delete</p>
                        <p class="text-gray-700 mb-4">Are you sure you want to delete this event?</p>
                        <input type="hidden" id="delete_event_id" name="delete_event_id" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                        <div class="flex justify-end">
                            <button id="cancelDelete" class="mr-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none">Cancel</button>
                            <button id="confirmDelete" name="confirm_delete_event" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none">Delete</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Delete Confirmation Modal -->
            <form method="post">
                <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                        <p class="text-xl font-semibold text-gray-800 mb-4">Confirm Delete</p>
                        <p class="text-gray-700 mb-4">Are you sure you want to delete this session?</p>
                        <input type="hidden" id="delete_session_title" name="delete_session_title" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                        <input type="hidden" id="delete_session_event_id" name="delete_session_event_id" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" readonly>
                        
                        <div class="flex justify-end">
                            <button id="cancelDelete" class="mr-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none">Cancel</button>
                            <button id="confirmDelete" name="confirm_delete_session" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none">Delete</button>
                        </div>
                    </div>
                </div>
            </form>


            <!-- Edit Modal -->
            <form method="post">
                <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                        <p class="text-xl font-semibold text-gray-800 mb-4">Edit Session</p>
                        <div class="mb-6">
                            <!-- Event Title -->
                            <label for="event_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Title</label>
                            <input type="hidden" id="event_id" name="event_id" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <input type="hidden" id="session_title_old" name="session_title_old" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            <!-- Session -->
                            <label for="session_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Session Title</label>
                            <input type="text" id="session_title" name="session_title" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <!-- Date -->
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                            <input type="text" id="date" name="date" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <!-- Time 1 -->
                            <label for="time_am" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time 1</label>
                            <input type="time" id="time_am" name="time_am" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <!-- Time 2 -->
                            <label for="time_pm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time 2</label>
                            <input type="time" id="time_pm" name="time_pm" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="flex justify-end">
                            <button id="cancelEdit" class="mr-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none">Cancel</button>
                            <button type="submit" id="confirm_edit_session" name="confirm_edit_session" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Edit Modal -->
            <form method="post">
                <div id="editModalEvent" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
                        <p class="text-xl font-semibold text-gray-800 mb-4">Edit Event</p>
                        <div class="mb-6">
                            <!-- Event Title -->
                            <input type="hidden" id="edit_event_id" name="edit_event_id" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">


                            <label for="event_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Title</label>
                            <input type="text" id="event_title" name="event_title" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        </div>
                        <div class="flex justify-end">
                            <button id="cancelEdit" class="mr-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none">Cancel</button>
                            <button type="submit" id="confirm_edit_event" name="confirm_edit_event" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>            

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
                    $eventSessions = getEventSessionsInfo($con, $event_id);
                ?>
                    <div class="mb-6">
                        <div class="w-full px-4 py-2 font-bold text-left text-gray-900 bg-gray-200 rounded dark:bg-gray-800 dark:text-white focus:outline-none">

                            <svg class="inline-flex mr-2" type="button" onclick="openDeleteModalEvent(<?php echo $event_id; ?>)" fill="#b91c1c" height="15px" width="15px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.775 460.775" xml:space="preserve" transform="matrix(-1, 0, 0, 1, 0, 0)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"></path>
                                </g>
                            </svg>

                            <svg class="inline-flex mr-2" type="button" onclick="openEditModalEvent('<?php echo addslashes($event['event_id']); ?>', '<?php echo addslashes($event['event_title']); ?>')" height="15px" width="15px" viewBox="0 -0.5 21 21" version="1.1" xmlns:xlink="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>edit [#fb923c]</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Dribbble-Light-Preview" transform="translate(-99.000000, -400.000000)" fill="#fb923c">
                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                <path d="M61.9,258.010643 L45.1,258.010643 L45.1,242.095788 L53.5,242.095788 L53.5,240.106431 L43,240.106431 L43,260 L64,260 L64,250.053215 L61.9,250.053215 L61.9,258.010643 Z M49.3,249.949769 L59.63095,240 L64,244.114985 L53.3341,254.031929 L49.3,254.031929 L49.3,249.949769 Z" id="edit-[#fb923c]"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>

                            <span><?php echo $event_title; ?></span>
                            <span class="toggleTable" type="button" class="float-right">▼</span>
                        </div>

                        <div class="collapsibleTable overflow-x-auto mt-2 hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Session</th>
                                            <th scope="col" class="px-4 py-3">Date</th>
                                            <th scope="col" class="px-4 py-3">Time 1</th>
                                            <th scope="col" class="px-4 py-3">Time 2</th>
                                            <th scope="col" class="px-4 py-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Replace with PHP logic to generate sessions -->
                                        <?php foreach ($eventSessions as $session) { ?>
                                            <tr class="border-b dark:border-gray-700">
                                                <td class="px-4 py-3"><?php echo $session['session_title']; ?></td>
                                                <td class="px-4 py-3"><?php echo $session['date']; ?></td>
                                                <td class="px-4 py-3"><?php echo $session['timeam']; ?></td>
                                                <td class="px-4 py-3"><?php echo $session['timepm']; ?></td>
                                                <td class="px-4 py-3">
                                                    <!-- Edit Button -->
                                                    <button type="button" onclick="openEditModal('<?php echo addslashes($session['session_title']); ?>', <?php echo $session['event_id']; ?>, '<?php echo $session['date']; ?>', '<?php echo $session['timeam']; ?>', '<?php echo $session['timepm']; ?>')" class="w-full rounded-lg border border-orange-400 px-3 py-1 text-center text-sm font-medium text-orange-400 hover:bg-orange-400 hover:text-white focus:outline-none focus:ring-4 focus:ring-orange-300 dark:border-orange-400 dark:text-orange-400 dark:hover:bg-orange-400 dark:hover:text-white dark:focus:ring-orange-900 lg:w-auto">Edit</button>
                                                    <!-- Delete Button -->
                                                    <button type="button" onclick="openDeleteModal('<?php echo addslashes($session['session_title']); ?>', <?php echo $session['event_id']; ?>)" class="w-full rounded-lg border border-red-700 px-3 py-1 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:bg-red-600 dark:hover:text-white dark:focus:ring-red-900 lg:w-auto">Delete</button>
                                                    </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>

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

        
<!-- Ensure you load SweetAlert2 library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
<?php
if (isset($_POST['confirm_delete_session'])) {
    // Assuming openConnection() function opens your database connection
    $con = openConnection();

    // Sanitize input (always recommended to prevent SQL injection)
    $delete_session_title = mysqli_real_escape_string($con, $_POST['delete_session_title']);
    $delete_session_event_id = mysqli_real_escape_string($con, $_POST['delete_session_event_id']);

    // Construct your DELETE SQL query
    $strSql = "DELETE FROM event_sessions WHERE session_title = '$delete_session_title' AND event_id = '$delete_session_event_id'";

    // Execute the query
    if (mysqli_query($con, $strSql)) {
        // Success message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Success!",
                    text: "Redirecting in 3 seconds. success to delete session.",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    } else {
        // Error message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Redirecting in 3 seconds. failed to delete session.",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    }

    // Close the database connection
    mysqli_close($con);
}

if (isset($_POST['confirm_edit_session'])) {
    $con = openConnection();

    // Sanitize input (always recommended to prevent SQL injection)
    $event_id = mysqli_real_escape_string($con, $_POST['event_id']);
    $session_title = mysqli_real_escape_string($con, $_POST['session_title']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $time_am = mysqli_real_escape_string($con, $_POST['time_am']);
    $time_pm = mysqli_real_escape_string($con, $_POST['time_pm']);
    $session_title_old = mysqli_real_escape_string($con, $_POST['session_title_old']);
    // Construct your UPDATE SQL query
    $strSql = "UPDATE event_sessions SET session_title = '$session_title', date = '$date', timeam = '$time_am', timepm = '$time_pm' WHERE session_title = '$session_title_old' and event_id = '$event_id'";
    // // Execute the query
    if (mysqli_query($con, $strSql)) {
        // Success message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Success!",
                    text: "Redirecting in 3 seconds. success to edit session.",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    } else {
    //     // Error message and redirect
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            Swal.fire({
                title: "Error!",
                text: "Redirecting in 3 seconds. failed to edit session.",
                icon: "error",
                timer: 3000,
                showConfirmButton: false
            }).then(function(){
                window.location.href = "./event_tailwind.php";
            });
        </script>
    ';
    }

    // Close the database connection
    mysqli_close($con);
}


if (isset($_POST['confirm_delete_event'])){
    
    $con = openConnection();

    // Sanitize input (always recommended to prevent SQL injection)
    $event_id = mysqli_real_escape_string($con, $_POST['delete_event_id']);
    $strSql = "UPDATE events set event_status = 0 where event_id = '$event_id'";

    if (mysqli_query($con, $strSql)) {
        // Success message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Success!",
                    text: "Redirecting in 3 seconds. success to delete event.",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    } else {
    //     // Error message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Redirecting in 3 seconds. Failed to edit event.",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    }
}

if (isset($_POST['confirm_edit_event'])){
    $con = openConnection();

    // Sanitize input (always recommended to prevent SQL injection)
    $event_id = mysqli_real_escape_string($con, $_POST['edit_event_id']);
    $event_title = mysqli_real_escape_string($con, $_POST['event_title']);
    
    $strSql = "UPDATE events set event_title = '$event_title' where event_id = '$event_id'";

    if (mysqli_query($con, $strSql)) {
        // Success message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Success!",
                    text: "Redirecting in 2 seconds. Successfully edited event.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    } else {
        // Error message and redirect
        echo '
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript">
                Swal.fire({
                    title: "Error!",
                    text: "Redirecting in 3 seconds. Failed to edit event.",
                    icon: "error",
                    timer: 3000,
                    showConfirmButton: false
                }).then(function(){
                    window.location.href = "./event_tailwind.php";
                });
            </script>
        ';
    }
}
?>



<script>
    // Functions to open/close modals
    function openDeleteModal(session_title, event_id) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById("delete_session_title").value = session_title;
        document.getElementById("delete_session_event_id").value = event_id;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function openEditModal(session_title, event_id, date, time_am, time_pm) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('event_id').value = event_id;
        document.getElementById('session_title').value = session_title;
        document.getElementById('session_title_old').value = session_title;
        
        document.getElementById('date').value = date;
        document.getElementById('time_am').value = time_am;
        document.getElementById('time_pm').value = time_pm;
    }

    function openDeleteModalEvent(event_id) {
        document.getElementById('deleteModalEvent').classList.remove('hidden');
        document.getElementById('delete_event_id').value = event_id;
        console.log(event_id);
    }

    function openEditModalEvent(edit_event_id, event_title) {
        document.getElementById('editModalEvent').classList.remove('hidden');
        document.getElementById('edit_event_id').value = edit_event_id;
        document.getElementById('event_title').value = event_title;
    }

    // function closeEditModal() {
    //     document.getElementById('editModal').classList.add('hidden');
    // }

    // Event listeners for cancel and confirm actions
    document.getElementById('cancelDelete').addEventListener('click', function() {
        closeDeleteModal();
    });

    document.getElementById('confirmDelete').addEventListener('click', function() {
        // Add logic to handle delete action
        closeDeleteModal();
    });

    document.getElementById('cancelEdit').addEventListener('click', function() {
        closeEditModal();
    });

    // document.getElementById('saveEdit').addEventListener('click', function() {
    //     // Add logic to handle save edit action
    //     closeEditModal();
    // });

</script>

