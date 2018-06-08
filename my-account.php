<?php include("header.php"); ?>
<div class="content-wrapper">
    <div class="container-fluid pt-5">
        <?php  $compte = selectCompte($_GET['id']);?>
        <div class="jumbotron jumbotron-fluid bg-gradient">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <h1 class="display-3">
                            <?= $compte[0]['name']; ?>
                        </h1>
                    </div>
                    <div class="col-sm-3 text-right">
                        <p class=" display-4">
                            <?= $compte[0]['currency']; ?>
                                <?= $compte[0]['amount']; ?>
                        </p>
                        <span>
                            <?= date("d-m-Y") ;?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
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
                <input type="hidden" name="idCompte" value="<?= $compte[0]['id']?>">
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                <?php $operations = selectOperations($_GET['id']); 
               foreach($operations as $operation){ ?>
                <tr>
                    <td>
                        <?php $cat = selectCategory($operation['idCategory']);?>
                        <i class="<?php iconCategory($operation['idCategory']) ;?>"></i>
                        <?= $cat[0]['name'];?>
                    </td>
                    <td class="w-50">
                        <div class="d-flex justify-content-between">
                            <span id="opName-<?= $operation['id'] ?>"><?= $operation['name'] ?></span> 
                             <form action="updateOp.php" method="post" class="updateInput">
                                 <input type="hidden" name="id" value="<?= $operation['id']?>" >
                                 <input type="text" name="name" value="<?= $operation['name']?>" >
                                 <button type="submit" class="btn btn-primary">Ok</button>
                             </form>
                       <span id="editBtn" onclick="toggleEdit(this, <?= $operation['id'] ?>)">
                         <i class="fas fa-pencil-alt"></i>
                       </span>
                        </div>
                    </td>
                    <td>
                        <?php if($cat[0]['type'] == 'debit'){ ?>
                        <span>-
                            <?= $operation['amount'] ?>
                        </span>
                        <?php } else { ?>
                        <span class="color-green">+
                            <?= $operation['amount'] ?>
                        </span>
                        <?php } ?>

                    </td>
                    <td class="text-center">
                        <i class="<?php iconPaymentMethod($operation['paymentMethod']) ?>"></i>
                    </td>
                    <td>
                        <?php $sqlDate= $operation['date'];
                   $date = strtotime($sqlDate); 
                   echo date("d-m-Y",$date);
                   ?>
                    </td>
                    <td class="text-center">
                        <form action="deleteOperation.php" method="post">
                            <input type="hidden" name="idCompte" value="<?=$operation['idCompte']?>">
                            <input type="hidden" name="id" value="<?=$operation['id']?>">
                            <button type="submit" class="confirm" onclick="confirm()">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php }?>
            </table>
        </div>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © Your Website 2018</small>
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
     </div>
             <!-- Bootstrap core JavaScript-->
             <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Page level plugin JavaScript-->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.min.js"></script>
     <?php include("footer.php"); ?>