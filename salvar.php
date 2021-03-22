<? 

error_reporting(E_ALL);
ini_set("display_error", 1);

header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

if($_SERVER['REQUEST_METHOD'] == "POST") { 
	$dados = $_POST;

	
	include 'db.inc.php';
	 
	$dados['usu_cpf'] = str_replace(".","",str_replace("-","",$dados['usu_cpf']));
	
	$sql = "SELECT * FROM usuario WHERE (usu_cpf = '{$cpf}' OR usu_cartao_sus = '{$dados['usu_cartao_sus']}') and usu_datanasc = '{$dados['usu_datanasc']}'";

	$resultado = pg_query($sql) or die(pg_last_error());

	if(pg_num_rows($resultado) == 0){
		$keys = "";
		$values = "";

		unset($dados['acao']);

		foreach($dados as $key => $value){
			if($key == "cidade"){
				$cid_codigo = pg_fetch_object(pg_query("SELECT cid_codigo FROM cidade WHERE cid_nome ilike '%$value%'"))->cid_codigo;
				$key = "usu_end_cidade";
				$value = $cid_codigo;
			}

			if($key == "uf_codigo"){
				$key = "usu_uf";
			}

			$keys .= $key.", ";
			$values .= "'{$value}', ";
		}

		$keys = substr($keys, 0, strlen($keys)-2);
		$values = substr($values, 0, strlen($values)-2);

		$sql = pg_query("insert into usuario ($keys) values ($values) RETURNING usu_codigo") or die(pg_last_error());
		
		$insert = pg_fetch_object($sql);

		$_SESSION['usu_codigo'] = $insert->usu_codigo;
		$_SESSION['dados'] = $dados;

		echo json_encode(array(
			"status"=>"success",
			"message"=>"Cadastro realizado com sucesso!<br><i>Quando acessar o sistema,<br>digite seu </i><b>CPF</b> <i>ou</i> <b>Cartão SUS</b> <i>e a</i> <b>senha</b> <i>será sua</i> <b>data de nascimento.</b></i>",
			"usu_codigo"=>$insert->usu_codigo,
			"data" => date("Y-m-d H:i:s"),
			"redirect" => "agendar.php"
		));
		
		exit;
	} else {
		echo json_encode(array(
			"status"=>"warning",
			"message"=>"Cadastro já existente! <br> Tente recuperar seus dados de acesso.",
			"data" => date("Y-m-d H:i:s"),
			"redirect"=>""
		));
	}
}