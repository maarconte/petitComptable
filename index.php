<?php include("header.php"); ?>

<body class=" signup fixed-nav sticky-footer bg-gradient d-flex align-items-center" id="page-top">`
    <div class="container">
        <div class="card card-register m-auto">
            <div class="row">
                <div class="col-sm-6 form">
                    <h1>Sign Up</h1>
                    <form id="signup" action="signup.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputPseudo">Pseudo</label>
                            <input type="text" name="pseudo" class="form-control" id="exampleInputPseudo" placeholder="Enter pseudo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" name="password1" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
                <div class="col-sm-6 bg-signup">

                </div>
            </div>

        </div>
    </div>