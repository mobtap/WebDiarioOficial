Resumo das funcionalidades:
1. Simula a conexão com o servidor local;
2. Permite utilizar a extensão para a geração de assinatura PDF no Windows, Linux e MacOS.

Para que a aplicação cliente funcione corretamente, é necessário configurar a extensão para permitir URLs locais. Deve-se realizar os seguintes passos:
1. Abra o arquivo assinatura.html;
2. A página solicitará a instalação da extensão, siga os passos de instalação;
3. Perceba que, quando voltar para a página da assinatura, ainda não será detectada a extensão. É necessário acessar as extensões (chrome://extensions), localize a extensão e marque a opção "Permitir acesso aos URLs do arquivo";
4. Execute o servidor.

O botão "Inicializar assinatura (Server-Framework) executa a função "inicializar" do arquivo "script-customizavel.js". Essa função acessa o servidor local (servidor) e envia os dados do certificado. A informação necessária do lado cliente para inicializar a assinatura no servidor é o conjunto de bytes do certificado. O retorno da chamada "inicializar" é o "retorno do processo de inicialização da assinatura no Framework" já transformado para ser utilizado pela extensão.
A função “BryApiModule.sign” utiliza os dados preparados (input) pela função anterior e assina as informações com o certificado selecionado pelo usuário, informando o “idSelectedCertificate”.
O próximo passo é a finalização da assinatura, função BryApiModule.finalizar, o exemplo realiza um post para o servidor local (servidor), passando esses dados de retorno da extensão. No servidor local, esses dados são processados e enviados para o BRy HUB.
