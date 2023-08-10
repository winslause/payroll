<?php
session_start();
include "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Admin | Employee's Payroll Management System</title>

    <?php include "header.php"; ?>
    <?php include "bar.php"; ?>




    <?php
    //session_start();

    // $_SESSION['login_name'] = "admin";
    //if (isset($_SESSION['login_name']))
    //header("location:index.php?page=home");

    ?>


    <?php
    try {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM admin WHERE aname=:username and password=:password";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);


            if ($query->rowCount() > 0) {
                $_SESSION['alogin'] = $_POST['username'];
                // $_SESSION['fullname'] = $results->fname;
                // $currentpage = $_SERVER['REQUEST_URI'];
                // echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";
                header('Location: dashboard.php');
            } else {

                echo "<script>alert('Invalid Details');</script>";
            }
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    ?>


</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        width: 100%;
        background: #007bff;
    }

    main#main {
        width: 100%;
        height: 100%;
        background: green;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #login-container {
        width: 50%;
        height: 100%;
        background: green;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    #login-right {
        flex: 1;
        background: #59b6ec61;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url(assets/img/Payroll.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    #login-right .card {
        width: 100%;
        max-width: 400px;
        margin: 2rem auto;
        padding: 1rem;
        z-index: 1;
        background: orange;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .logo {
        margin: auto;
        font-size: 8rem;
        background: none;
        padding: 0;
        border-radius: 50% 50%;
        color: #000000b3;
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 150px;
        width: 150px;
    }

    .instructions {
        text-align: center;
        margin-bottom: 1rem;
    }

    .instructions p {
        margin: 0;
    }

    div#login-right::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(100%);
        height: calc(100%);
        background: orange;
    }

    .create-account-link {
        margin: 1rem;
        text-decoration: underline;
        color: #fff;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .forgot-password-link {
        margin: 1rem;
        text-decoration: underline;
        color: #fff;
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .back-button {
        margin: 1rem;
        text-decoration: underline;
        color: #fff;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    #forgot-password-form {
        display: none;
    }
</style>

<body>
    <main id="main">
        <div id="login-container">
            <div id="login-right">
                <div class="card col-md-8">
                    <div class="card-body">
                        <div class="logo">
                            <img src="../assets/img/payroll1.png" alt="Jkuat Logo">
                        </div>
                        <div class="welcome">
                            <h3 style="text-align: center; font-weight: bold;">ADMIN LOGIN</h3>
                        </div>
                        <div class="instructions">
                            <!-- <h4>ADMIN LOGIN</h4> -->
                            <!-- <p><?php echo "To log in, enter your Employee ID as your username and then your password."; ?></p> -->
                        </div>
                        <form id="login-form" method="post">
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
                        </form>
                        <!-- Create an Account link -->
                        <!-- <a href="create_account.php" class="create-account-link">Create an Account</a> -->
                        <!-- Forgot Password link -->
                        <a href="#" id="forgot-password-link" class="forgot-password-link">Forgot Password</a>
                        <!-- Back button (on the forgot password page) -->
                        <a href="#" id="back-button" class="back-button" style="display: none;">Back to Login</a>
                    </div>
                </div>
                <div id="forgot-password-form">
                    <div class="card col-md-8">
                        <div class="card-body">
                            <div class="instructions">
                                <p><?php echo "Enter your email address to reset your password."; ?></p>
                            </div>
                            <form id="reset-password-form">
                                <div class="form-group">
                                    <label for="email" class="control-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                                <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Reset Password</button></center>
                            </form>
                            <!-- Back button (on the reset password page) -->
                            <a href="#" id="back-to-login-button" class="back-button">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
<!-- <script>
	$('#login-form').submit(function(e) {
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
		if ($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'ajax.php?action=login',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err)
				$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success: function(resp) {
				if (resp == 1) {
					location.href = 'index.php?page=home';
				} else if (resp == 2) {
					location.href = 'voting.php';
				} else {
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	});

	$('#forgot-password-link').click(function(e) {
		e.preventDefault();
		$('#login-form').hide();
		$('#forgot-password-form').show();
	});

	$('#back-button').click(function(e) {
		e.preventDefault();
		$('#login-form').show();
		$('#forgot-password-form').hide();
	});

	$('#reset-password-form').submit(function(e) {
		e.preventDefault();
		// Add code to handle the password reset process and send an email to the user's email address.
		// You can use AJAX to submit the form data to the server for processing.
		// For the sake of simplicity, I'll skip the actual email sending part in this code snippet.
		alert('Password reset email sent to the provided email address.');
		$('#reset-password-form')[0].reset();
		$('#login-form').show();
		$('#forgot-password-form').hide();
	});
</script> -->

</html>