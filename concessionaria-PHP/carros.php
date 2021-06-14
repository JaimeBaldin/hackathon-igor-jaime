<?php
	session_start(); //iniciando uma sessão

	include "conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="estilos.css">
	<title>Cherry Véiculos</title>
</head>
<body>

	<header>
		<?php
			include "topo.php";
		?>
	</header>

	<section id="carros">
		<?php
			$dir='carros/';

			$maximo_registros_exibidos=4;
			if (isset($_GET["pg"])) {
				$pagina_atual=$_GET["pg"];
			} else {
				$pagina_atual=1;
			}

			$inicio=$pagina_atual-1;
			$inicio*=$maximo_registros_exibidos;

			//$sql="SELECT * FROM veiculo";
			//$result=mysqli_query($con, $sql);

			$sql="SELECT * FROM veiculo LIMIT $inicio,$maximo_registros_exibidos"; //Limitando maximo de carros por pagina
			$result=mysqli_query($con, $sql);
			$total_registros=mysqli_num_rows(mysqli_query($con, "SELECT * FROM veiculo"));
			$total_paginas=$total_registros/$maximo_registros_exibidos;

			$anterior=$pagina_atual-1;
			$proxima=$pagina_atual+1;

			if ($pagina_atual > 1) {
				echo "<a class='btmenu' href='carros.php?pg=$anterior'>Anterior</a>";
			}
			if ($pagina_atual < $total_paginas) {
				echo "<a class='btmenu' href='carros.php?pg=$proxima'>Próxima</a>";
			}
			echo "<br>";
			for ($indice_paginas=0;$indice_paginas<$total_paginas;$indice_paginas++) { 
				echo "<a href='carros.php?pg=".($indice_paginas+1)."'>[";
				if ($pagina_atual == ($indice_paginas+1)) {
					echo "<strong>".($indice_paginas+1)."</strong>";
				}else{
					echo ($indice_paginas+1);
				}
					echo " ]</a>";
			}
			echo "<br><br>";

			while ($dados=mysqli_fetch_array($result)) {
				echo "<article>".
						"<div id='d1'>".
							"<img src='".$dir.$dados['fotoDestaque']."' width='200px' height='200'>". 
						"</div>".
						"<div id='d2'>".
							"<div id='titulo'>".
								"<div id='t1'>".
									"<p>".$dados['modelo']."</p>".
								"</div>".
								"<div id='t2'>".
									"<p>R$".number_format($dados['valor'],2,',','.')."</p>". //number_format(valor, casas_decimais, sep_dec, sep_mil);
								"</div>".
							"</div>".
							"<div id='dados'>".
								"<p>".$dados['anoFabricacao']."/".$dados['anoModelo']."</p>".
								"<p>".$dados['tipo']."</p>".
								"<p>".$dados['opcionais']."</p>".
							"</div>".
						"</div>".
					"</article>"
				;
			}
		?>
	</section>

	<footer>
				<?php
			include "rodape.html";
		?>
	</footer>

</body>
</html>