<?php include("header.php"); ?>
<div class="content-wrapper">
  <div class="container-fluid pt-5 pb-5">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="./dashboard.php">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">My Dashboard</li>
    </ol>
    <!-- Comptes -->
    <?php ?>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal" <?php if($verifyAccounts == 10 ){echo 'disabled';} ?> >
      <i class="fas fa-plus-circle"></i> Compte
    </button>
    <?php 
   if($verifyAccounts == 10 ){
       echo 'Vous avez atteint le nombre maximum de comptes';
   }?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter un compte</h5>
          </div>
          <div class="modal-body">
            <form method="post" action="addAccount.php">
              <div class="form-group">
                <input name="name" type="text" class="form-control" id="exampleInputName" placeholder="Nom">
              </div>
              <div class="form-group">
                <select name="type" class="form-control" id="exampleFormType">
                  <?php  $types = get_enum_values('comptes','type'); 
                      foreach($types as $type) {
                      ?>
                  <option>
                    <?= $type?>
                  </option>
                  <?php }?>
                </select>
              </div>
              <div class="row">
                <div class="form-group col-sm-10">
                  <input name="amount" type="text" class="form-control" id="exampleInputAmount" placeholder="Solde">
                </div>
                <div class="form-group col-sm-2">
                  <select name="currency" class="form-control" id="exampleFormCurrency">
                    <?php  $currencies = get_enum_values('comptes','currency'); 
              foreach($currencies as $currency) {
              ?>
                    <option>
                      <?= $currency?>
                    </option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal end -->
    <!-- Account List -->
    <div class="accordion account-list mb-5" id="accordionExample">
      <?php $comptes = selectAccount($_SESSION['users']['id']);
         foreach($comptes as $compte){ ?>
      <div class="card mb-2">
        <div class="card-header" id="headingOne">
          <div class="row" style="margin-left: inherit !important;margin-right: inherit !important;">
            <div class="d-flex col-8 align-items-center">
              <h5 id="accountName-<?= $compte['id']?>">
                <?= $compte['name']?>
              </h5>
              <form action="updateAccountName.php" method="post" class="ml-2 updateInput">
                <input type="hidden" name="id" value="<?= $compte['id']?>" >
                <input type="text" name="name" value="<?= $compte['name']?>" >
                <button type="submit" class="btn btn-primary">Ok</button>
              </form>
                  <span id="editBtn" onclick="toggleEdit(this, <?= $compte['id']?>)">
                    <i class="ml-2 fas fa-pencil-alt"></i>
                  </span>
            </div>
            <div class="col-3 pt-2 pb-2 d-flex justify-content-end">
              <div class="text-right">
                <p class="balance">
                  <strong>
                    <?= $compte['amount']?>
                      <?= $compte['currency']?>
                  </strong>
                </p>
                <?php $lastOp = selectLastOperation($compte['id']);
                    //  echo count($lastOp);
                      if(count($lastOp) == 1) {
                        $sqlDate= $lastOp[0]['date'];
                        $date = strtotime($sqlDate);
                ?>
                  <small>
                    <?= date("d-m-Y", $date)?>
                      <span class="balance-credit">
                        <?php $cat = selectCategory($lastOp[0]['idCategory']);
                    ?>
                        <?php if($cat[0]['type'] == 'debit'){ ?>
                        <span>-
                          <?= $lastOp[0]['amount'] ?>
                        </span>
                        <?php } else { ?>
                        <span class="color-green">+
                          <?= $lastOp[0]['amount'] ?>
                        </span>
                        <?php } ?>
                      </span>
                  </small>
                        <?php } ?>
              </div>
            </div>
            <div id="add-operation-<?= $compte['id']?>" class="add-operation col-1 d-flex align-items-center justify-content-center">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $compte['id']?>" aria-expanded="true"
                aria-controls="collapse<?= $compte['id']?>">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>


        </div>

        <div id="collapse<?= $compte['id']?>" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <!-- Operation -->
            <div id="new-operation-<?= $compte['id']?>" class="new-operation">
              <form class="form-inline" method="post" action="addOperation.php">
                <div class="form-group mx-sm-3">
                  <label for="staticName" class="sr-only">Nom</label>
                  <input name="name" type="text" class="form-control" id="name" placeholder="Nom">
                </div>
                <div class="form-group mx-sm-3">
                  <label for="staticMontant" class="sr-only">Montant</label>
                  <input name="amount" type="text" class="form-control" id="amount" placeholder="Montant">
                </div>

                <div class="form-group mx-sm-3 ">
                  <select name="idCategory" class="form-control" id="exampleFormControlSelect1">
                    <?php $cats = selectCategories();
            foreach($cats as $cat) {
            ?>
                    <option value="<?= $cat['id'];?>">
                      <?= $cat['name'];?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mx-sm-3 ">
                  <select name="paymentMethod" class="form-control" id="exampleFormControlSelect1">
                    <?php  $pms = get_enum_values('operations','paymentMethod'); 
          foreach($pms as $pm) {
          ?>
                    <option>
                      <?= $pm; ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <input type="hidden" name="idCompte" value="<?= $compte['id']?>">
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </form>
            </div>
            <!-- Operation end -->
          </div>
        </div>
      </div>
      <?php }?>
    </div>

    <!-- Account List end -->
    <!-- Comptes end -->

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <?php include("footer.php"); ?>

  </div>