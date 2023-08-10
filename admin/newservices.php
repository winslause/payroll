<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

?>


	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>Issue Salary </title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>

	</head>

	<body style="display: flex;">
		<?php include('includes/header.php'); ?>

		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper" style="width: 100%;">
				<div class="container-fluid">

					<div>
						<div class="col-md-12">

							<h2 class="page-title">Gross Salary</h2>

							<!-- Zero Configuration Table -->
							<div class="panel panel-default">
								<div class="panel-heading">Salary Info</div>
								<div class="panel-body">

									<form method="post">

										<div class="form-group" style="margin: 10px;">
											<label for="exampleInputEmail1"> Employee Name</label>
											<input type="text" name="empname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Add Employee Name" required />

											<small id="emailHelp" class="form-text text-muted"></small>
										</div>
										<div class="form-group" style="margin: 10px;">
											<label for="exampleInputEmail1"> Employee Number</label>
											<input type="text" name="empnumber" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Add Employee Number" required />
											<small id="emailHelp" class="form-text text-muted"></small>
										</div>
										<div class="form-group" style="margin: 10px;">
											<label for="exampleInputEmail1"> Month</label>
											<input type="month" name="month" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="month" required />
											<small id="emailHelp" class="form-text text-muted"></small>
										</div>
										<div class="form-group" style="margin: 10px;">
											<label for="exampleInputEmail1">Gross Salary</label>
											<input type="number" name="salary" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="salary" required />
											<small id="emailHelp" class="form-text text-muted"></small>
										</div>





										<button type="submit" name="save" class="btn btn-primary">SUBMIT</button>
									</form>




								</div>
							</div>



						</div>
					</div>

				</div>
			</div>

		</div>

		<!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
	</body>

	</html>



<?php } ?>
<?php
if (isset($_POST['save'])) {
	$employname = $_POST['empname'];
	$employeenumber = $_POST['empnumber'];
	$month = $_POST['month'];
	// $email1 = $_SESSION['login'];
	$salary = $_POST['salary'];
	$sql = "INSERT INTO  salary(username,empno,month,gross) VALUES(:employname,:employeenumber,:month,:salary)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':employname', $employname, PDO::PARAM_STR);
	$query->bindParam(':employeenumber', $employeenumber, PDO::PARAM_STR);
	$query->bindParam(':month', $month, PDO::PARAM_STR);
	$query->bindParam(':salary', $salary, PDO::PARAM_STR);
	// $query->bindParam(':email1', $_SESSION['login'], PDO::PARAM_STR);
	$query->execute();
	$lastInsertId = $dbh->lastInsertId();
	if ($lastInsertId) {
		function calculatePAYE($grossIncome)
		{
			$taxRate = 0;

			switch ($grossIncome) {
				case $grossIncome >= 200000:
					$taxRate = 30;
					break;
				case $grossIncome >= 150000 && $grossIncome < 200000:
					$taxRate = 25;
					break;
				case $grossIncome >= 100000 && $grossIncome < 150000:
					$taxRate = 20;
					break;
				case $grossIncome >= 50000 && $grossIncome < 100000:
					$taxRate = 15;
					break;
				default:
					$taxRate = 0;
					break;
			}

			$tax = $grossIncome * $taxRate / 100;

			return $tax;
		}




		$employname = $_POST['empname'];
		$month = $_POST['month'];
		$payee = calculatePAYE($salary);


		$nssf = $salary * 0.12;
		$nhif = $salary * 0.0275;
		$helb = $salary * 0.25;
		$basic = $salary - ($nhif + $nssf + $payee + $helb);
		$sql = "UPDATE salary SET payee=:payee, nssf=:nssf, nhif=:nhif, helb=:helb, basic=:basic WHERE  username=:employname AND month=:month";
		$query = $dbh->prepare($sql);
		$query->bindParam(':employname', $employname, PDO::PARAM_STR);
		$query->bindParam(':month', $month, PDO::PARAM_STR);
		$query->bindParam(':payee', $payee, PDO::PARAM_STR);

		$query->bindParam(':nssf', $nssf, PDO::PARAM_STR);
		$query->bindParam(':nhif', $nhif, PDO::PARAM_STR);
		$query->bindParam(':helb', $helb, PDO::PARAM_STR);
		$query->bindParam(':basic', $basic, PDO::PARAM_STR);
		$query->execute();
		// $msg = "Your Request Service  Successfully submited";
		echo "<script>alert('Success. Gross salary confirmed');</script>";
		header('location: dashboard.php');
	} else {
		echo "<script>alert('Something went wrong. Please try again');</script>";
	}
}


?>