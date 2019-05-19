<?php
require_once("conecta.php");

function buscarRemedio($no,$la,$lo){
    global $conexao;   
    $servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$database = "farma";

		$conn = new mysqli($servername, $username, $password, $database);

		if ($conn->connect_error) {
			die("Falha na conex&atilde;: " . $conn->connect_error);
		}

		$sql = "SELECT DISTINCT unidade.numero numero, unidade.nome nome, unidade.endereco endereco, unidade.lat lat, unidade.lon lon, unidade.telefone telefone FROM catmat, estoque, unidade where lat <> 0 and catmat.nome='" . $no . "' and catmat.numero = estoque.catmat and unidade.numero = estoque.unidade ORDER BY numero ASC";

		$result = $conn->query($sql);


		if ($result->num_rows > 0) {
			
			$i = 0;
			
		    while($row = $result->fetch_assoc()) {

			  $i = $i + 1;
              $lat[$i] = $row["lat"];
              $lon[$i] = $row["lon"];
			  $tudo[$i] = $row;

	          $r[$i] = sqrt(($lat[$i] - $la) * ($lat[$i] - $la) + ($lon[$i] - $lo) * ($lon[$i] - $lo)) *160.28;

	          $tudo[$i] += ["distancia" => $r[$i]];

		    }

			function cmp($a, $b) {
				return $a['distancia'] > $b['distancia'];
			}
			usort($tudo, 'cmp');

			
			return $tudo;
			
		}
		return null;

		$conn->close();
}