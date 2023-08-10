<?php
session_start();
error_reporting(0);
include('db_connect.php');
if (strlen($_SESSION['login']) == 0) {
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

        <title> report </title>

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

            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                top: 0px;
            }
        </style>

    </head>

    <body style="background-color: #fff; font-size:15px;">
        <?php include('header1.php'); ?>


        <div >

            <div >
                <div >

                    <div >
                        <div >

                            <h2 class="page-title">SALARY</h2>

                            <!-- Zero Configuration Table -->
                            <div >
                                <div class="panel-heading">Salary Info</div>
                                <div  style="margin-top:0; top:0%; bottom:100px;">

                                    <table width="90%" style="margin-top:0; top:0%; bottom:100px;">
                                        <thead>
                                            <tr>
                                                <th>#</th>

                                                <th style="border: 1px solid black;">USERNAME</th>
                                                <th style="border: 1px solid black;">EMPLOYEE NUMBER</th>
                                                <th style="border: 1px solid black;">MONTH</th>
                                                <th style="border: 1px solid black;">GROSS SALARY</th>
                                                <th style="border: 1px solid black;">PAYEE</th>
                                                <th style="border: 1px solid black;">NSSF</th>
                                                <th style="border: 1px solid black;">NHIF</th>
                                                <th style="border: 1px solid black;">HELB</th>

                                                <th style="border: 1px solid black;">Basic salary</th>


                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>

                                                <th style="border: 1px solid black;">USERNAME</th>
                                                <th style="border: 1px solid black;">EMPLOYEE NUMBER</th>
                                                <th style="border: 1px solid black;">MONTH</th>
                                                <th style="border: 1px solid black;">GROSS SALARY</th>
                                                <th style="border: 1px solid black;">PAYEE</th>
                                                <th style="border: 1px solid black;">NSSF</th>
                                                <th style="border: 1px solid black;">NHIF</th>
                                                <th style="border: 1px solid black;">HELB</th>

                                                <th style="border: 1px solid black;">Basic salary</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <?php

                                            //  $status = 0;
                                            // $email = $_SESSION['login'];

                                            $sql = 'SELECT * FROM users s
											JOIN salary t ON s.username = t.username';
                                            $query = $dbh->prepare($sql);
                                            // $query->bindParam(':email', $email, PDO::PARAM_STR);
                                            // $query->bindParam(':gmail', $gmail, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {

                                                foreach ($results as $result) {
                                                    $name = $_SESSION['login'];

                                                    if (($result->employnumber) == $name) {



                                            ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->username); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->employnumber); ?></td>


                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->month); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->gross); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->payee); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->nssf); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->nhif); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->helb); ?></td>
                                                            <td style="border: 1px solid black;"><?php echo htmlentities($result->basic); ?></td>


                                                            <br>



                                                            <br>
                                                            <br>

                                                            <br>

                                                            </td>

                                                        </tr>
                                            <?php $cnt = $cnt + 1;
                                                    }
                                                }
                                            } ?>

                                        </tbody>
                                    </table>



                                </div>
                            </div>





                        </div>
                    </div>

                </div>

            </div>
        </div>

        </div>
        </div>
        </div>

       

    </html>
<?php } ?>