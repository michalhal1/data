<?php
// Include config file
require_once "config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $input_log_email = trim($_POST["email"]);
    $input_log_password = trim($_POST["password"]);

    $sql_login = "SELECT log_password, log_name FROM tenders_test.logins t 
    where log_active = 1 and log_mail = ? ";


    if ($stmt = mysqli_prepare($link, $sql_login)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $log_email);

        $log_email = $input_log_email;

        if (mysqli_stmt_execute($stmt)) {
            $sql_results = mysqli_stmt_get_result($stmt);
            


            if (mysqli_num_rows($sql_results) > 0) {
                $row1 = mysqli_fetch_array($sql_results, MYSQLI_ASSOC);
                $password_sql = $row1["log_password"];
            } else {
?>
                <div class="alert alert-danger text-center"><?php echo "Nieprawidłowy email lub hasło!"; ?></div>
            <?php }
        }
    }


    if (mysqli_num_rows($sql_results) > 0) {
        if (mysqli_stmt_execute($stmt) and $password_sql == $input_log_password) {
            // Records created successfully. Redirect to landing page
            //echo "Dodano nowy przetarg";
            header("location: index.php");

            exit();
        } else {
            ?>
            <div class="alert alert-danger text-center"><?php echo "Nieprawidłowy email lub hasło!"; ?></div>
<?php }
    }
}
?>















<!DOCTYPE html>
<html>

<head>
    <title>Logowanie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="bootstrap.css" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <style type="text/css">
        #login-form .input-group,
        #login-form .form-group {
            margin-top: 30px;
        }

        #login-form .btn-default {
            background-color: #EEE;
        }

        .brand {
            color: #CCC;
        }

        .container {
            margin-left: 25%;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 30px;">
        <div class="col-sm-6 col-sm-offset-">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="login-form" method="post" role="form">
                        <legend>Zaloguj się do bazy przetargowej</legend>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="text" name="email" placeholder="Wpisz adres e-mail" required class="form-control" />
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" placeholder="Wpisz hasło" required class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block" />
                        </div>
                        <div class="form-group">
                            <hr />


                        </div>
                    </form>
                </div>
            </div>
        </div>


        <h2></h2>
        <img src="impel_z.jpg" alt="Trulli" width="550" height="280">
    </div>
</body>

</html>