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
        <script src="tailwind.config.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    </head>
        
    </head>
   
    <body class="transition-colors duration-300 ease-in-out dark:bg-gray-800" id="body">
        
        <!-- Sidebar -->
        <?php include 'sidebar_tailwind.php'; ?>

        
        <!-- Events -->
        <section class="p-4 sm:ml-64">
            <div class="flex justify-between">
                <h2 class="w-50 mb-4 text-2xl tracking-tight font-bold text-gray-900 dark:text-white">Events</h2>
                <button onclick="window.location.href='add_event_tailwind.php';" type="submit" form="eventForm" name="btnSubmit"  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg height="20px" width="20px" fill="#eeeeee" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 612 612" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M499.641,320.573c-12.207-3.251-25.021-5.011-38.25-5.011c-1.602,0-3.189,0.071-4.781,0.119 c-78.843,2.506-142.118,66.556-143.375,145.709c-0.015,0.799-0.062,1.587-0.062,2.391c0,15.85,2.515,31.102,7.119,45.422 C339.474,568.835,395.381,612,461.391,612c81.859,0,148.219-66.359,148.219-148.219 C609.609,395.151,562.954,337.441,499.641,320.573z M461.391,561.797c-54.133,0-98.016-43.883-98.016-98.016 s43.883-98.016,98.016-98.016s98.016,43.883,98.016,98.016S515.523,561.797,461.391,561.797z"></path> <polygon points="475.734,396.844 442.266,396.844 442.266,449.438 389.672,449.438 389.672,482.906 442.266,482.906 442.266,535.5 475.734,535.5 475.734,482.906 528.328,482.906 528.328,449.438 475.734,449.438 "></polygon> <path d="M126.703,112.359c9.228,0,16.734-7.507,16.734-16.734V54.984v-38.25C143.438,7.507,135.931,0,126.703,0h-14.344 c-9.228,0-16.734,7.507-16.734,16.734v38.25v40.641c0,9.228,7.506,16.734,16.734,16.734H126.703z"></path> <path d="M389.672,112.359c9.228,0,16.734-7.507,16.734-16.734V54.984v-38.25C406.406,7.507,398.899,0,389.672,0h-14.344 c-9.228,0-16.734,7.507-16.734,16.734v38.25v40.641c0,9.228,7.507,16.734,16.734,16.734H389.672z"></path> <path d="M274.922,494.859c-2.333-11.6-3.572-23.586-3.572-35.859c0-4.021,0.177-7.999,0.435-11.953H74.109 c-15.845,0-28.688-12.843-28.688-28.688v-229.5h411.188v88.707c3.165-0.163,6.354-0.253,9.562-0.253 c11.437,0,22.61,1.109,33.469,3.141V93.234c0-21.124-17.126-38.25-38.25-38.25h-31.078v40.641c0,22.41-18.23,40.641-40.641,40.641 h-14.344c-22.41,0-40.641-18.231-40.641-40.641V54.984H167.344v40.641c0,22.41-18.231,40.641-40.641,40.641h-14.344 c-22.41,0-40.641-18.231-40.641-40.641V54.984H40.641c-21.124,0-38.25,17.126-38.25,38.25v363.375 c0,21.124,17.126,38.25,38.25,38.25H274.922z"></path> <circle cx="137.165" cy="260.578" r="37.954"></circle> <circle cx="251.016" cy="260.578" r="37.954"></circle> <circle cx="364.867" cy="260.578" r="37.954"></circle> <circle cx="251.016" cy="375.328" r="37.953"></circle> <circle cx="137.165" cy="375.328" r="37.953"></circle> </g> </g> </g></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Add Event</span>
                </button>
            </div>
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
                        <div class="flex w-full px-4 py-2 font-bold text-left text-gray-900 bg-gray-200 rounded dark:bg-gray-800 dark:text-white focus:outline-none">
                            <div class="flex items-center space-x-2 mt-1">
                                <a onclick="openDeleteModalEvent(<?php echo $event_id; ?>)" class="inline-flex mr-2">
                                    <svg height="20px" width="20px" viewBox="0 0 24 24" fill="ff0000" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8.00386 9.41816C7.61333 9.02763 7.61334 8.39447 8.00386 8.00395C8.39438 7.61342 9.02755 7.61342 9.41807 8.00395L12.0057 10.5916L14.5907 8.00657C14.9813 7.61605 15.6144 7.61605 16.0049 8.00657C16.3955 8.3971 16.3955 9.03026 16.0049 9.42079L13.4199 12.0058L16.0039 14.5897C16.3944 14.9803 16.3944 15.6134 16.0039 16.0039C15.6133 16.3945 14.9802 16.3945 14.5896 16.0039L12.0057 13.42L9.42097 16.0048C9.03045 16.3953 8.39728 16.3953 8.00676 16.0048C7.61624 15.6142 7.61624 14.9811 8.00676 14.5905L10.5915 12.0058L8.00386 9.41816Z" fill="#ff0000"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM3.00683 12C3.00683 16.9668 7.03321 20.9932 12 20.9932C16.9668 20.9932 20.9932 16.9668 20.9932 12C20.9932 7.03321 16.9668 3.00683 12 3.00683C7.03321 3.00683 3.00683 7.03321 3.00683 12Z" fill="#ff0000"></path> </g></svg>
                                </a>

                                <a onclick="openEditModalEvent('<?php echo addslashes($event['event_id']); ?>', '<?php echo addslashes($event['event_title']); ?>')"  class="inline-flex mr-2">
                                    <svg height="20px" width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12V11.5C20 10.9477 20.4477 10.5 21 10.5C21.5523 10.5 22 10.9477 22 11.5V12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2H12.5C13.0523 2 13.5 2.44772 13.5 3C13.5 3.55228 13.0523 4 12.5 4H12Z" fill="#a86f17"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M17.2156 2.82088C17.7412 2.29528 18.4541 2 19.1974 2C19.9407 2 20.6535 2.29528 21.1791 2.82088C21.7047 3.34648 22 4.05934 22 4.80265C22 5.54596 21.7047 6.25883 21.1791 6.78443L20.396 7.56757C20.0055 7.9581 19.3723 7.9581 18.9818 7.56757L16.4324 5.01824C16.0419 4.62771 16.0419 3.99455 16.4324 3.60402L17.2156 2.82088ZM15.0182 6.43245C14.6277 6.04192 13.9945 6.04192 13.604 6.43245L9.14269 10.8938C9.01453 11.0219 8.92362 11.1825 8.87966 11.3583L8.02988 14.7575C7.94468 15.0982 8.04453 15.4587 8.29291 15.7071C8.54129 15.9555 8.90178 16.0553 9.24256 15.9701L12.6417 15.1204C12.8175 15.0764 12.9781 14.9855 13.1062 14.8573L17.5676 10.396C17.9581 10.0055 17.9581 9.37231 17.5676 8.98179L15.0182 6.43245Z" fill="#a86f17"></path> </g></svg>
                                </a>

                                <a href="participants_tailwind.php?event_id=<?php echo $event_id; ?>" class="inline-flex mr-2">
                                    <svg height="20px" width="20px" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 5.5C5 4.11929 6.11929 3 7.5 3C8.88071 3 10 4.11929 10 5.5C10 6.88071 8.88071 8 7.5 8C6.11929 8 5 6.88071 5 5.5Z" fill="#0080ff"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0C3.35786 0 0 3.35786 0 7.5C0 11.6421 3.35786 15 7.5 15C11.6421 15 15 11.6421 15 7.5C15 3.35786 11.6421 0 7.5 0ZM1 7.5C1 3.91015 3.91015 1 7.5 1C11.0899 1 14 3.91015 14 7.5C14 9.34956 13.2275 11.0187 11.9875 12.2024C11.8365 10.4086 10.3328 9 8.5 9H6.5C4.66724 9 3.16345 10.4086 3.01247 12.2024C1.77251 11.0187 1 9.34956 1 7.5Z" fill="#0080ff"></path> </g></svg>
                                </a>
                            </div>
                            
                            <button id="toggleTable_<?php echo $event_id; ?>" class="w-full px-4 py-2 font-bold text-left text-gray-900 bg-gray-200 rounded dark:bg-gray-800 dark:text-white focus:outline-none">
                                <?php echo $event['event_title']; ?>
                                <span id="toggleIcon_<?php echo $event_id; ?>" class="float-right">▼</span>
                            </button>
                        </div>

                        <div id="collapsibleTable_<?php echo $event_id; ?>" class="overflow-x-auto mt-2 hidden">
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

