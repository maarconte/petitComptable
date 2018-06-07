<?php include("header.php"); ?>
<div class="content-wrapper">
    <div class="container-fluid pt-5">
        <?php  $compte = selectCompte($_GET['id']);?>
        <div class="jumbotron jumbotron-fluid">
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
                        <?= $operation['name'] ?>
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
                    <td>
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

        <!-- Area Chart Example-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-area-chart"></i> Area Chart Example</div>
            <div class="card-body">
                <canvas id="myAreaChart" width="100%" height="30"></canvas>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <!-- Example Bar Chart Card-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-bar-chart"></i> Bar Chart Example</div>
                    <div class="card-body">
                        <canvas id="myBarChart" width="100" height="50"></canvas>
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Example Pie Chart Card-->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-pie-chart"></i> Pie Chart Example</div>
                    <div class="card-body">
                        <canvas id="myPieChart" width="100%" height="100"></canvas>
                    </div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
            </div>
        </div>
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
     <?php include("footer.php"); ?>