<?php
require('./functions.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Petit comptable</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="./vendor/confirm/msc-style.css">
  <script src="./vendor/confirm/msc-script.js"></script>
  
</head>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top conforta" id="mainNav">
  <a class="navbar-brand " href="dashboard.php">Petit comptable</a>

  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive"
    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
        <a class="nav-link" href="dashboard.php">
        <i class="fas fa-chart-line"></i>
          <span class="nav-link-text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
        <i class="fas fa-money-check"></i>
          <span class="nav-link-text">Mes Comptes</span>
        </a>
        <ul class="sidenav-second-level collapse" id="collapseComponents">
          <?php $comptes = selectAccount($_SESSION['users']['id']);
         foreach($comptes as $compte){ ?>
          <li class="d-flex align-items-center justify-content-between">
            <a href="my-account.php?id=<?= $compte['id'] ?>">
              <?= $compte['name'] ?>
            </a>
            <form action="deleteAccount.php" method="post">
              <input type="hidden" name="compteId" value="<?= $compte['id']?>">
              <button type="submit" class="confirm mr-3" onclick="confirm()">
                <i class="far fa-trash-alt"></i>
              </button>
            </form>
          </li>
          <?php } ?>
        </ul>
      </li>
    </ul>
    <ul class="navbar-nav sidenav-toggler">
      <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
          <i class="fa fa-fw fa-angle-left"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item text-right">
        <a href="#" class="navbar-brand">
          <i class="fas fa-user mr-2"></i>
          <?= $_SESSION['users']['pseudo']; ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="loggout.php">
          <i class="fa fa-fw fa-sign-out"></i>Logout</a>
      </li>
    </ul>
  </div>
</nav>