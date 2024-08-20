<?php

include_once("../functions/common_function.php");
include('config.php');

function countRecords($table, $con) {
    $countQuery = "SELECT COUNT(*) as recordCount FROM `$table`";
    $result = mysqli_query($con, $countQuery);

    $recordCount = 0;
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $recordCount = $row['recordCount'];
    }

    mysqli_free_result($result);

    return $recordCount;
}

function countRecordsWithStatus($table, $con, $statuses) {
    $statusCondition = implode("', '", $statuses);
    $countQuery = "SELECT COUNT(*) as recordCount FROM `$table` WHERE status IN ('$statusCondition')";
    $result = mysqli_query($con, $countQuery);

    $recordCount = 0;
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $recordCount = $row['recordCount'];
    }

    mysqli_free_result($result);

    return $recordCount;
}

$userCount = countRecords('user_table', $con);
$roomCount = countRecords('rooms', $con);
$facilityCount = countRecords('facilities', $con);
$featureCount = countRecords('features', $con);

$pendingBookingsCount = countRecordsWithStatus('book_details', $con, ['pending']);
$approvedBookingsCount = countRecordsWithStatus('book_details', $con, ['approved']);
$cancelledBookingsCount = countRecordsWithStatus('book_details', $con, ['cancelled']);

mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .center {
            align-items: center;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .card {
            width: 18rem;
            margin-bottom: 20px;
        }
    </style>
    <title>Document</title>
</head>

<body>

    <h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i
            class="bi bi-house-heart-fill fa-2x"></i> Welcome <?php echo $_SESSION['admin_name'] ?></h3>

    <div class="card-container row">
        <!-- Users -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="fa fa-users text-danger align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo $userCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-danger text-light text-center fw-bold">Customers</li>
                </ul>
            </div>
        </div>
        <!-- Pending Bookings -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="fa fa-money text-warning fa-4x canter"></i></h5>
                        <p class="card-text fs-5"><?php echo $pendingBookingsCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-warning text-light text-center fw-bold">Pending Bookings</li>
                </ul>
            </div>
        </div>
        <!-- Approved Bookings -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="fa fa-check-circle text-success align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo $approvedBookingsCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-success text-light text-center fw-bold">Approved Bookings</li>
                </ul>
            </div>
        </div>
        <!-- Cancelled Bookings -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="bi bi-x-circle-fill text-danger align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo $cancelledBookingsCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-danger text-light text-center fw-bold">Cancelled Bookings</li>
                </ul>
            </div>
        </div>

        <!-- Rooms -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="bi bi-house-check-fill text-dark align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo $roomCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dark text-light text-center fw-bold">Rooms</li>
                </ul>
            </div>
        </div>
        <!-- Facilities -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="bi bi-house-gear-fill text-dark align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo $facilityCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dark text-light text-center fw-bold">Facilities</li>
                </ul>
            </div>
        </div>
        <!-- Features -->
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i class="bi bi-house-up-fill text-danger align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo $featureCount; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-danger text-light text-center fw-bold">Features</li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <center>
                    <div class="card-body bg-light">
                        <h5 class="card-title"><i
                                class="fas fa-calendar-alt text-success align-items-center fa-4x"></i></h5>
                        <p class="card-text fs-5"><?php echo "Today is " . date("Y/m/d") . "<br>"; ?></p>
                    </div>
                </center>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-success text-light text-center fw-bold">Date</li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>
