<?php
include('../admin/config.php');
include('../functions/common_function.php');
include('../inc/links.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="print.css" media="print">
    <title>success</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap");
        .logo {
            width: 10%;
            height: 10%;
        }

        .container {
            margin-top: 20px; /* Adjusted margin-top for padding after the navbar */
            padding: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .custom-table {
        padding: 3 15px;
    }

        /* Added some styling for the button */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        #print-btn {
            padding: 10px 20px;
            font-size: 18px;
        }
        /* Styles for hover effect */
  .custom-btn:hover {
    color: white !important;
  }
    </style>
</head>

<body>
    <!-- NAVBAR -->

    <!-- header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><strong> WELCOME </strong><?php echo $_SESSION['cust_name'] ?></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active me-2" aria-current="page" href="userindex.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="facilities.php">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book_details.php"><i class="bi bi-building-check"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book.php">Booking History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2 custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="color: black; text-decoration: none;">
                        <a href="../admin/logout.php" style="color: inherit; text-decoration: none;">Logout</a>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <h1 class="text-center py-4 text-success fs-4 fw-bold text-uppercase"><i class="fa-regular fa-circle-check fa-2x"></i> Payment Successful! </h1>
    <p class="border-bottom text-center">Your payment has been processed! Details of transactions are included below</p>
    <table class="table table-bordered border-dark mt-5 custom-table">
        <thead class="bg-dark text-center text-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Room Name</th>
                <th>Check In Date</th>
                <th>Check Out Date</th>
                <th>Paid Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_id = get_user_id_fromsession();
            $username = $_SESSION['cust_name'];
            $email = user_email();
            $cart_query = "SELECT rooms.room_id, booking_id, Name, Image, checkindate, checkoutdate, price, status,
        DATEDIFF(checkoutdate, checkindate) * price as room_price
        FROM `book_details`, `rooms` 
        WHERE book_details.room_id=rooms.room_id AND book_details.user_id=$user_id";
            $result = mysqli_query($con, $cart_query);
            while ($row = mysqli_fetch_array($result)) {
                $room_title = $row['Name'];
                $room_image1 = $row['Image'];
                $checkindate = $row['checkindate'];
                $checkoutdate = $row['checkoutdate'];
                $renting_price = $row['room_price'];
                echo "<tr class='text-center'>
                                <td>$username</td>
                                <td>$email</td>
                                <td>$room_title</td>
                                <td>$checkindate</td>
                                <td>$checkoutdate</td>
                                <td>Rs.$renting_price/-</td>
                                </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="button-container">
        <button onclick="window.print();" class="btn btn-primary" id="print-btn">PRINT Receipt</button>
    </div>
</body>

</html>
