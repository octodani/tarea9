<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Personajes Marvel</title>
		<style>
			* {margin: 0}
			header {position: fixed; width: 100%; background-color: white; padding: 30px}
			h1 {padding: 10px}
			body {font-family: Arial, Helvetica, Sans-serif; text-align: center}
			img {width: 400px}
			main {text-align: center; padding-top: 160px}
			.personaje {border: 1px solid black; border-radius: 5px; width: 800px; padding: 20px; margin: auto; margin-bottom: 20px}
		</style>

	</head>
	<body>
		<?php
			$publicAPIkey = "e8eafb4708ffa6377e9beca6ab3c4402";
			$privateAPIkey = "8c7beb40de4be41dfe8833dbf671906f5d613198";
			$cod = md5('0'.$privateAPIkey.$publicAPIkey);

			if (isset($_POST["boton"])) {
				$json = file_get_contents("https://gateway.marvel.com:443/v1/public/characters?ts=0&apikey=e8eafb4708ffa6377e9beca6ab3c4402&hash=".$cod."&limit=100&offset=".$_POST["listas"]);
				$datos = json_decode($json, true);
				
			} else {
				$json = file_get_contents("https://gateway.marvel.com:443/v1/public/characters?ts=0&apikey=e8eafb4708ffa6377e9beca6ab3c4402&hash=".$cod."&limit=100&offset=0");
				$datos = json_decode($json, true);
			}
		?>

		<header>
			<h1>Lista de personajes de Marvel</h1>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<select name="listas" id="">
					<?php
						for ($i = 0; $i < $datos["data"]["total"]; $i = $i + 100) {
							$recuento = $i + 99;
							echo "<option value=\"{$i}\">Mostar resultados ".$i." - ".$recuento."</option>";
						}
					?>
				</select>
				<input type="submit" value="Mostrar" name="boton">
			</form>
		<br>
		</header>

		<main>
			<?php
				foreach($datos["data"]["results"] as $dato) {
					echo '<div class="personaje">';
					echo '<h2>'.$dato["name"].'</h2>';
					echo '<p>'.$dato["description"].'<p><br>';

					echo "<img src=".$dato["thumbnail"]["path"].".".$dato["thumbnail"]["extension"]."><br>";
					echo '</div>';
				}
			?>
		</main>
	</body>
</html>