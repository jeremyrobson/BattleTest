<?php
    $nav_username = isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest";
?>

<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Navbar</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php?p=home">Home <span class="sr-only">(current)</span></a>
      </li>
      <?php
      if (isset($_SESSION["username"])):
      ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?p=login&amp;action=logout">Logout</a>
      </li>
      <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?p=login">Login</a>
      </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?p=register">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <h4>Welcome, <?=$nav_username?></h4>
    </form>
  </div>
</nav>