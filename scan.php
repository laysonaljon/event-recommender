<?php
    session_start();
    include 'connection.php';
    $user_id = $_SESSION['user_id'];
    include 'lib/QrReader.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="calendar-svgrepo-com.svg" type="image/svg+xml">
    <title>Event</title>
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


    <?php include'link.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-calendar"></i>SCAN QR</h6>
                        </div>
                        <div class="card-body">
                        <h1>QR Code Scanner</h1>
                        <?php
                            if (isset($_GET['success']) && $_GET['success'] == 1) {
                                echo '<p>Successfully Attended! <b>'. $_GET['email'] .'</b> </p>';
                            }
                            elseif (isset($_GET['success']) && $_GET['success'] == 2) {
                                echo "<p>Already scanned</p>";
                            }
                        ?>
                        <video id="qr-video" width="400" height="300" autoplay playsinline></video>
                        <form id="qr-form" method="post" action="process_qr.php">
                            <input type="hidden" name="event_id" value="<?php echo $_GET['eventID']; ?>">
                            <input type="hidden" name="session_title" value="<?php echo $_GET['session_title']; ?>">
                            <input class="form-control" id="scanned-data" type="text" name="scanned_data" placeholder="Scanned Data" readonly>
                            <div id="qr-result"></div>
                        </form>
                        <script src="scanner.js"></script>
                        </div>
                    </div>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Participants Email</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $con = openConnection();
                                    $event_id = $_GET['eventID'];
                                    $session_title = $_GET['session_title'];
                                    $strSql = "SELECT * FROM attendance where event_id = '$event_id' and session_title = '$session_title'";
                                    $result = getRecord($con, $strSql);
                                    foreach ($result as $key => $session) {
                                        echo 
                                        '<tr>
                                            <td>' . ($key + 1) . '</td>
                                            <td>' . $session['email'] . '</td>
                                            <td>' . $session['dateIn'] . '</td>
                                            <td>' . $session['timeIn'] . '</td>
                                        </tr>';
                                    }
                                    closeConnection($con);

                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <script>
            const video = document.getElementById('qr-video');
            const qrResult = document.getElementById('qr-result');
            const scannedDataInput = document.getElementById('scanned-data'); // Input field to display scanned data

            const scanner = new Instascan.Scanner({ video: video });
            scanner.addListener('scan', function (content) {
                qrResult.innerText = content;

                // Update the input field with scanned data
                scannedDataInput.value = content;

                // Submit the form automatically
                document.forms[0].submit(); // Assuming it's the first form on the page
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (err) {
                console.error('Error accessing the camera:', err);
            });

            </script>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <?php include'script.php'; ?>

</body>
</html>

