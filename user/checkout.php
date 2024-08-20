<?php
include('../admin/config.php');
include('../functions/common_function.php');
include('../inc/links.php');
$user_id = get_user_id_fromsession();
$cart_query = "SELECT rooms.room_id, booking_id, Name, Image, checkindate, checkoutdate, price, status,
DATEDIFF(checkoutdate, checkindate) * price * 0.0075 as room_price
FROM `book_details`, `rooms` 
WHERE book_details.room_id=rooms.room_id AND book_details.user_id=$user_id";
$result = mysqli_query($con, $cart_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Integration (Stripe)</title>
    <link rel="stylesheet" href="css/_style.css" />
    <style>
        body {
            background-color: white; /* Set background color to white */
        }

        /* Adjusted layout for form and picture */
        .row {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Vertically center the content */
        }

        .col-md-6 {
            width: 48%;
        }

        .back {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .custom-btn {
    color: black;
    text-decoration: none;
  }

  /* Styles for hover effect */
  .custom-btn:hover {
    background-color: black;
    color: white;
  }
    </style>
</head>

<body>

    <!-- Header Navbar -->
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
    <!-- End of Navbar -->

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) {
            $room_title = $row['Name'];
            $renting_price = $row['room_price'];
        ?>
            <div class="col-md-6">
                <div class="form-container">
                    <!-- Your form code -->
                    <form autocomplete="off" action="checkout-charge.php" method="POST">
                        <div>
                            <input type="text" name="c_name" required />
                            <label>Customer Name</label>
                        </div>
                        <div>
                            <input type="text" name="address" required />
                            <label>Address</label>
                        </div>
                        <div>
                            <input type="number" id="ph" name="phone" pattern="\d{10}" maxlength="10" required />
                            <label>Contact number</label>
                        </div>
                        <div>
                            <input type="text" name="product_name" value="<?php echo $room_title ?>" disabled required />
                            <label>Room name</label>
                        </div>
                        <div>
                            <input type="text" name="price" value="$<?php echo $renting_price ?>" disabled required />
                            <label>Price</label>
                        </div>

                        <input type="hidden" name="amount" value="<?php echo $renting_price ?>">
                        <input type="hidden" name="product_name" value="<?php echo $room_title ?>">

                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_51MMijBHmrwinhnCe2WzXT0EvwvTN2L0CTuBmqn4oGPCBAA6ElxPHcw9JTvN4jxWpUCnRO1RUeWewSmP9pnmXYQuI00Zqv5ZyYL" data-amount=<?php echo str_replace(",", "", $renting_price)  * 100 ?> data-name="HMS" data-description="Hotel Management System" data-image="../images/rooms/1.jpg" data-currency="usd" data-locale="auto">
                        </script>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="checkout-container">
                    <h4>Room Name: <?php echo $room_title ?></h4>
                    <img src="../uploads/rooms/<?php echo $row['Image'] ?>" />
                    <span>Renting Price: $<?php echo $renting_price ?> </span>
                </div>
            </div>
        <?php } ?>
    </div>

</body>

</html>
