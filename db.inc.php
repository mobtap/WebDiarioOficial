<?
//
// Connect to PostgreSQL.
//
  #
  # CONFIGURACAO DE BANCO POSTGRES
  #
  $host = "localhost";
  $dbuser = "postgres";
  $dbsenha = "123";
  $dbname = "diario_oficial";
  $porta = "5432";
  $schema = "public";
 
$db = pg_connect("host=$host dbname=$dbname user=$dbuser password=$dbsenha port=$porta") or die("Nao Conectado");;
	pg_query("SET CLIENT_ENCODING=LATIN1");
	pg_query("SET datestyle = 'European, DMY'");

?>
