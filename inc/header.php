<style>
  /* Add custom styles to make the text white */
  .custom-btn {
    color: black !important;
  }
  /* Add styles to make the text white when hovering */
  .custom-btn:hover {
    color: white !important;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">HMS</a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active me-2" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="rooms.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facilities.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      </ul>
      <div class="d-flex">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2 custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
            <a href="./user/user_login.php" style="color: inherit; text-decoration: none;">Sign In</a>
        </button>

        <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2 custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
            <a href="./user/user_registration.php" style="color: inherit; text-decoration: none;">Sign Up</a>
        </button>
      </div>
    </div>
  </div>
</nav>
