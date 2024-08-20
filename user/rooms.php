<?php
include('../functions/common_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi - ROOMS</title>
    <?php 
    require(dirname(__DIR__).'/inc/links.php') ?>
    <style>
        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card .btn {
            font-size: 0.8rem;
        }
        .custom-btn {
    color: black;
    text-decoration: none;
  }

  
  .custom-btn:hover {
    color: white !important;
  }
    </style>
</head>

<body class="bg-light">
    <!-- header -->
    <?php include(dirname(__DIR__).'/inc/links.php') ?>
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
    <!-- end of header -->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
        <div class="h-line bg-dark"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">FILTERS</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <div>
                                <div class="border bg-light p-3 rounded mb-3">
                                    <div class="list-group">
                                        <h3>Price</h3>
                                        <input type="hidden" id="hidden_minimum_price" value="0" />
                                        <input type="hidden" id="hidden_maximum_price" value="65000" />
                                        <p id="price_show">25000 - 90000</p>
                                        <div id="price_range"></div>
                                    </div>
                                </div>
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">CATEGORIES</h5>
                                    <?php
                                    // Your database connection code here
                                    include(dirname(__DIR__,1).'/admin/config.php');

                                    // Fetch categories from the database
                                    $categoryQuery = "SELECT id, name FROM categories";
                                    $categoryResult = mysqli_query($con, $categoryQuery);

                                    // Check if there are categories
                                    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                                        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                                            $categoryId = 'c_' . $categoryRow['id'];
                                    ?>
                                            <div class="mb-2">
                                                <input type="checkbox" id="<?php echo $categoryId; ?>" value="<?php echo $categoryRow['name']; ?>" class="form-check-input shadow-none me-1 categories">
                                                <label class="form-check-label" for="<?php echo $categoryId; ?>"><?php echo $categoryRow['name']; ?></label>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        // Handle the case when no categories are found
                                        echo '<p>No categories available at the moment.</p>';
                                    }

                                    // Close the database connection
                                    mysqli_close($con);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9 col-md-12 px-4" id="searchResults">
                <?php
                // Your existing code to display rooms
                ?>
            </div>
        </div>
    </div>
    <!-- jQuery and jQuery UI scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Additional scripts and libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- footer -->
    <?php require(dirname(__DIR__).'/inc/footer.php') ?>
    <script>
        $(document).ready(function() {
            filter_data();

            function filter_data() {
                var action = 'fetch_data';
                var minimum_price = $('#hidden_minimum_price').val();
                var maximum_price = $('#hidden_maximum_price').val();
                var categories = get_filter('categories'); // Get selected categories

                $.ajax({
                    url: "fetch_data.php",
                    method: "POST",
                    data: {
                        action: action,
                        minimum_price: minimum_price,
                        maximum_price: maximum_price,
                        categories: categories,
                    },
                    success: function(data) {
                        $("#searchResults").html(data);
                    }
                });
            }

            function get_filter(class_name) {
                var filter = [];
                $('.' + class_name + ':checked').each(function() {
                    filter.push($(this).val());
                });
                return filter;
            }
            $('#price_range').slider({
                range: true,
                min: 25000,
                max: 90000,
                values: [25000, 90000],
                step: 50,
                stop: function(event, ui) {
                    $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                    $('#hidden_minimum_price').val(ui.values[0]);
                    $('#hidden_maximum_price').val(ui.values[1]);
                    filter_data();
                }
            });
            // Handle category checkbox change event
            $('.categories').change(function() {
                filter_data(); // Call filter_data() when category checkboxes are changed
            });
        });
    </script>
</body>

</html>