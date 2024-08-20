<?php
if (isset($_POST['submit'])) {
  $NAME=$_POST['name'];
  $EMAIL=$_POST['email'];
  $SUBJECT=$_POST['subject'];
  $MESSAGE=$_POST['msg'];
  $user_id = get_user_id_fromsession();
  $insert = "INSERT INTO `contact`(`user_id`, `Name`, `Email`, `SUBJECT`, `Message`) VALUES ('$user_id',
 '$NAME','$EMAIL','$SUBJECT','$MESSAGE')";
  $result_query = mysqli_query($con, $insert);
  if ($result_query) {  
    echo "<script>alert('Message sent successfully')</script>";
    echo "<script>window.open('contact.php', '_self')</script>";  
  } else {
    echo "<script>alert('Error!')</script>";
  }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi -CONTACT US</title>
    <?php require('inc/links.php') ?>
    
</head>
<body class="bg-light">
<!-- header -->
<?php require('inc/header.php') ?>
 <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">CONTACT US</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Minus rerum non ipsum alias assumenda dolor deleniti 
        labore velit cumque ab.
    </p>   
 </div>

 <div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-5 px-4">
            <div class="bg-white rounded shadow p-4">
            <iframe class="w-100 rounded mb-4" height="320px"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0010898905243!2d85.32137247524038!3d27.71725262505495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19377c2c6743%3A0x971897caf9b0bb96!2sSifal!5e0!3m2!1sen!2snp!4v1695431095158!5m2!1sen!2snp" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <h5>Address</h5>
            <a href="https://maps.app.goo.gl/usQcLnHKSWYhbxCR8" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
            <i class="bi bi-geo-alt-fill"></i> Sifal, Kathmandu, Nepal
            </a>
            <h5 class="mt-4">Call Us</h5>
          <a href="tel: +9779869031332" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +9779869031332</a>
          <br>
          <h5 class="mt-4">Email</h5>
          <a href="mailto: shristi.kharel@deerwalk.edu.np" class="d-inline-block text-decoration-none text-dark">
          <i class="bi bi-envelope-fill"></i> shristi.kharel@deerwalk.edu.np</a>
          <h5 class="mt-4">Follow Us</h5>
          <a href="#" class="d-inline-block text-dark fs-5 me-2">
          <i class="bi bi-twitter-x me-1"></i> 
          </a>
          <a href="#" class="d-inline-block text-dark fs-5 me-2">
          <i class="bi bi-meta"></i> 
          </a>
          <a href="https://www.instagram.com/instagram/" class="d-inline-block text-dark fs-5"> 
          <i class="bi bi-instagram"></i> 
          </a>
            </div>
        </div>

<!-- 1 -->

<div class="col-lg-6 col-md-6 px-4">
    <div class="bg-white rounded shadow p-4">
        <form>
            <h5>Send a message!</h5>
            <div class="mt-3">
    <label class="form-label" style="font-weight:500;">Name</label>
    <input type="text" class="form-control shadow-none">
  </div>
  <div class="mt-3">
    <label class="form-label" style="font-weight:500;">Email</label>
    <input type="email" class="form-control shadow-none">
  </div>
  <div class="mt-3">
    <label class="form-label" style="font-weight:500;">Subject</label>
    <input type="text" class="form-control shadow-none">
  </div><div class="mt-3">
    <label class="form-label" style="font-weight:500;">Message</label>
    <textarea class="form-control shadow-none" rows="5" style="resize: none"></textarea>
    <div class="form-outline mb-4 mt-3 w-50">
                <input type="submit" name="submit" class="btn btn-dark text-white mb-3 px-3" value="SEND">
            </div>
    
    <!-- <button type="submit" name="submit" class="btn text-white custom-bg mt-3">
        SEND
    </button>   -->
</div>

        </form>
    </div>
</div>

<!-- 2 -->






    </div>
 </div>

<!-- footer -->
<?php require('inc/footer.php') ?>

</body>
</html>