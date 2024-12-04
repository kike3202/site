
<?php 
require_once "pdo.php";


if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$failure = false;
$success = false;

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {

	$make = htmlentities($_POST['make']);
	$year = htmlentities($_POST['year']);
	$mileage = htmlentities($_POST['mileage']);

	if (strlen($make) < 1 ) {
		$failure = "Make is required";
	}
	elseif (! is_numeric($year) || (! is_numeric($mileage)) || strlen($year) < 1 || strlen($mileage) < 1) {
		$failure = "Mileage and year must be numeric";
	}
	else {

		$stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    	$stmt->execute(array(
        ':mk' => $make,
        ':yr' => $year,
        ':mi' => $mileage)
    );
    	$success = "Record inserted";

	}
}

$stmt = $pdo->query("SELECT make, year, mileage FROM autos ORDER BY mileage");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
    body{
        margin: 0px auto;
        background-color: grey;
    }
   
    form{
        background-color: white;
        padding: 10px;
        margin: 100px auto;
        width: 400px;
        position: relative;
    }
    input{
        padding: 10px;
        width: 380px;
    }
    input[type="submit"]{
        border: 0px;
        background-color: #ed8824;
        padding: 10px 20px;
        width: 200px;
      position: relative;
      left: 27%;
    }

   
 
.titulo{
    text-align: center;
    font-size: 20px;
    font-weight: 600;
}

.List_auto{
    background-color: white;
        padding: 10px;
        margin: 100px auto;
        width: 300px;
        position: relative;
        text-align: center;
        top: -70px;

}
.List_auto p{
    text-align: left;
    margin-left: -20px;
}
</style>

   
</head>
<body>


<div class="contenedor">
    



<form method="post">
    <div class="titulo">
<p>Tracking Autos From Johan</p>
</div>


<?php
if ( $failure !== false ) {
    print '<p style="color:red">';
    print htmlentities($failure);
    print "</p>\n";
}
else {
	print '<p style="color:green">';
	print htmlentities($success);
	print "</p>\n";
}
?>
<p>Make:
<input type="text" name="make" size="40"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="mileage" name="mileage"></p>
<p><input type="submit" value="Add New"/></p>
<input type="submit" name="logout" value="Logout">

<a href="http://....jpg" target="_blank">Ford</a>
<a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
</form>
<div class="List_auto">
<h2>Automobiles</h2>

<p>

<?php
foreach ($rows as $row) {
	echo "<ul><li>";
	echo ($row['year']);
	echo " ";
	echo ($row['make']);
	echo " ";
	echo "/";
	echo " ";
	echo ($row['mileage']);
	echo "</li></ul>\n";
}

?>
</p>
</div>



</body>




</html>
