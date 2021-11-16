<?php
require "dbBroker.php";
require "model/task.php";

session_start();

if(!isset($_SESSION['user_id'])){
	header('Location:index.php');
	exit();
}

$data = Task::getByUser($_SESSION['user_id'], $conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

</head>
<body>
	<div class="container">
		<h1 style="letter-spacing: .2em;" class="font-weight-bold text-light text-center mt-5 mb-n5">TO DO</h1>
		<div id="task-container">
			<div id="form-wrapper">
				<div class="text-center text-danger" id="message"></div>
				<form id="form">
					<div class="flex-wrapper">
					<input id="id" class="form-control" type="hidden" name="id">
						<div style="flex: 10">
							<label for="title">Naziv</label>
							<input id="title" class="form-control" type="text" name="title" placeholder="Naziv zadatka">
						</div>
						<div style="flex: 1;"></div>
						<div style="flex: 3">
							<label for="priority">Prioritet</label>
							<input id="priority" class="form-control" type="number" name="priority" placeholder="1-10">
						</div>
						<div class="break"></div>
						<div style="flex: 10">
							<label for="description">Opis</label>
							<input id="description" class="form-control" type="text" name="description" placeholder="Opis zadatka">
							<input type="hidden" name="user_id"  value="<?php echo $_SESSION['user_id'];?>">
						</div>
						<div class="break"></div>
						<div style="flex: 1">
							<input id="submit" class="btn" value="Potvrdi" type="submit" >
						</div>
						<div style="flex: 1 text-center">
							<input id="submit" class="btn" value="Poništi" type="reset" onclick="ponisti();" >
						</div>
						<div style="flex: 6">
							<button style="float: right;" onclick="sortByPriority();" class="btn btn-info">Sortiraj po prioritetu</button>
						</div>
					</div>
				</form>
			</div>

			<div id="list-wrapper">
				<div class="task-wrapper font-weight-bold flex-wrapper">
                    <div style="flex:5">
                        Naziv zadatka
                    </div>
					<div style="flex:1">
                        Prioritet
                    </div>
					<div style="flex:3">
                        Datum i vreme
                    </div>
                </div>
				<div id="sort">
				<?php
                    foreach(array_reverse($data) as $row):
                ?>
                <div id="data-row-<?php echo $row['id'] ?>" class="task-wrapper flex-wrapper">
                    <div title="<?php echo $row['opis'] ?>" style="flex:7">
					<?php echo $row['naslov'] ?>
                    </div>
					<div style="flex:1">
					<?php echo $row['prioritet'] ?>
                    </div>
					<div style="flex:2">
					<?php $date = new DateTime($row['vreme']); echo $date->format("d.m. H:i"); ?>
                    </div>
                    <div style="flex:1">
                        <button class="btn btn-sm btn-outline-info edit" 
						onclick="uredi(<?php echo $row['id'] ?>, '<?php echo $row['naslov'] ?>', <?php echo $row['prioritet'] ?>, '<?php echo $row['opis'] ?>');">Uredi</button>
                    </div>
                    <div style="flex:1">
                        <button class="btn btn-sm btn-outline-danger delete" onclick="obrisi(<?php echo $row['id'] ?>);">Obriši</button>
                    </div>
                </div>
				<?php
				endforeach;
				?>
				</div>
			</div>	
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>