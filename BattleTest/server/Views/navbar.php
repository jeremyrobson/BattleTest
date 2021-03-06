<?php
    $nav_username = isset($_SESSION["user"]) ? $_SESSION["user"]->username : "Guest";
    $logged = isset($_SESSION["user"]);
?>

<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Battle</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
        <!-- Home -->
      <li class="nav-item <?php if ($page == "home") { echo 'active'; } ?>">
        <a class="nav-link" href="index.php?page=home">Home <span class="sr-only">(current)</span></a>
      </li>

      <?php
      if ($logged):
      ?>
      <!-- Logout -->
      <li class="nav-item">
        <a class="nav-link" href="index.php?page=login&amp;action=logout">Logout</a>
      </li>
      <?php else: ?>
      <!-- Login -->
      <li class="nav-item <?php if ($page == "login") { echo 'active'; } ?> ">
        <a class="nav-link" href="index.php?page=login">Login</a>
      </li>
      <!-- Register -->
      <li class="nav-item <?php if ($page == "register") { echo 'active'; } ?> ">
        <a class="nav-link" href="index.php?page=register">Register</a>
      </li>
      <?php endif; ?>

      <!-- View -->
      <li class="nav-item dropdown">
        <a class="nav-link <?php if (!$logged) { echo 'disabled'; } ?> <?php if (in_array($page, array("party","material","itemtype","jobclass"))) { echo 'active'; } ?> dropdown-toggle" id="navbarDropdownMenuLink" href="#" data-toggle="dropdown">
            View
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?page=party">Party</a>
          <a class="dropdown-item" href="index.php?page=material">Materials</a>
          <a class="dropdown-item" href="index.php?page=itemtype">Item Types</a>
          <a class="dropdown-item" href="index.php?page=jobclass">Job Classes</a>
        </div>
      </li>

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <h4>Welcome, <?=$nav_username?></h4>
    </form>
  </div>
</nav>