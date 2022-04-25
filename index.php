<?php
### database identifications ###
$host = "localhost";
$user = "root";
$pass = "";
$db = "training_company";

#### connection to the database server ##### 
$conn = mysqli_connect($host, $user, $pass, $db);

#### a create operation ####
if (isset($_POST['send'])) {
    $name = $_POST['courseName'];
    $cost = $_POST['courseCost'];
    $sql_insert = "INSERT INTO `courses` VALUES (null, '$name', $cost)";
    $i = mysqli_query($conn, $sql_insert);
    if ($i) {
        echo "<div class='alert alert-success m-auto w-50'>Data inserted successfully</div>";
    }
}

### a select operation ####
$sql_select = "SELECT * FROM courses";
$s = mysqli_query($conn, $sql_select);
if (isset($_GET['Delete'])) {
    $id = $_GET['Delete'];
    $sql_delete = "DELETE FROM courses WHERE id = $id";
    $d = mysqli_query($conn, $sql_delete);
    header("location: index.php");
}

$name = "";
$cost = "";
$update = false;

#### an update operation ####
if (isset($_GET['Edit'])) {
    $update = true;
    $id = $_GET['Edit'];
    $sql_select_update = "SELECT * FROM courses WHERE id = $id";
    $s_u = mysqli_query($conn, $sql_select_update);
    $row = mysqli_fetch_assoc($s_u);
    $name = $row['name'];
    $cost = $row['cost'];
    if (isset($_POST['update'])) {
        $name = $_POST['courseName'];
        $cost = $_POST['courseCost'];
        $sql_update = "UPDATE courses SET name = '$name', cost = $cost WHERE id = $id";
        $u = mysqli_query($conn, $sql_update);
        header("location: index.php");
    }
}

#### a delete operation ####
if (isset($_GET['Change'])) {
    $num = $_GET['Change'];
    $sql_change = "UPDATE `color` SET color = $num";
    $c = mysqli_query($conn, $sql_change);
    header("location: index.php");
}
$selectColor = "SELECT * FROM color WHERE id = 1";
$s_c = mysqli_query($conn, $selectColor);
$row_c = mysqli_fetch_assoc($s_c);
$color = $row_c['color'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>

<body>
    <?php if ($color == 1) { ?>
        <link rel="stylesheet" href="./dark.css">
    <?php } else { ?>
        <link rel="stylesheet" href="./light.css">
    <?php } ?>

    <?php
    if ($color == 1) : ?>
        <a href="index.php?Change=2" class="btn btn-light">Light Mode</a>
    <?php else : ?>
        <a href="index.php?Change=1" class="btn btn-dark">Dark Mode</a>
    <?php endif; ?>

    <!-- input fields -->
    <div class="container col-5 mt-5 text-center">
        <div class="card card-body">
            <form method="POST">
                <div class="form-group">
                    <label> Course Name</label>
                    <input type="text" value="<?php echo $name ?>" name="courseName" class="form-control" placeholder="Enter Course Name">
                </div>
                <div class="form-group">
                    <label> Course Cost</label>
                    <input type="text" value="<?php echo $cost ?>" name="courseCost" class="form-control" placeholder="Enter Course Cost">
                </div>
                <?php if ($update == true) : ?>
                    <button class="btn btn-warning ml-3" name="update">Update Data</button>
                <?php else : ?>
                    <button class="btn btn-info" name="send">Send Data</button>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- the table of Data  -->
    <div class="container col-5 mt-5 text-center">
        <table class="table table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Cost</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>

            <?php
            foreach ($s as $data) { ?>
                <tr>
                    <th> <?php echo $data['id']; ?></th>
                    <th> <?php echo $data['name']; ?></th>
                    <th> <?php echo $data['cost']; ?></th>
                    <th> <a onclick="return confirm('Are you Sure that you want to delete this item ?')" href="index.php?Delete=<?php echo $data['id'] ?>" class="btn btn-danger">Delete</a></th>
                    <th> <a href="index.php?Edit=<?php echo $data['id'] ?>" class="btn btn-primary">Edit</a></th>
                </tr>
            <?php } ?>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
</body>

</html>