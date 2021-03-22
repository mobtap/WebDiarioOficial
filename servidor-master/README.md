O lado do servidor foi confeccionado em node.js. Esse serviço simula um servidor local e, a partir dele, são realizadas as chamadas para o BRy HUB.

O arquivo “index.js” habilita as rotas para inicializar e finalizar as assinaturas, que são utilizadas pela aplicação cliente. 

No arquivo .env, existe a necessidade de customização da tag <ACCESS_TOKEN> com o valor de:
* Token JWT em Minhas Aplicações em uma conta pessoal.
* Token JWT em Aplicações da Empresa em uma conta corporativa.

Para executar o exemplo, são necessários dois passos:

1.	Instalar dependências através do comando “npm install”;
2.	Executar o servidor com o comando “node index”.

O servidor estará executando na porta 8080.
