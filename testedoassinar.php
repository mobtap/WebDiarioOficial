<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Exemplo de funcionalidade da extensão para assinatura digital</title>
    <link rel="stylesheet" href="cliente-master/css/bootstrap.min.css">

    <style media="screen">
        .extension-message {
            padding-top: 55px;
            padding-bottom: 55px;
        }

        .btn-extension-install {
            margin-bottom: 55px;
        }
    </style>
    <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/dhikfimimcjpoaliefjlffaebdeomeni">
</head>

<body>
    <div class="container">
        <div id="extensao-instalada">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-6">
                    <select class="form-control" id="select-certificado-list"
                        onchange="BryApiModule.fillCertificateDataForm();"></select>
                </div>
                <a class="btn btn-default" href="#" onclick="BryApiModule.listCertificates()"><span
                        class="glyphicon glyphicon-refresh"></span></a>
            </div>
            <div class="row">
                <h4>Dados do certificado selecionado:</h4>
            </div>
            <div class="row">
                <form action="#" class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nome: </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" readonly value="Nome" id="input-nome">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Emissor: </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" readonly value="Emissor" id="input-emissor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Data de validade: </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" readonly value="Data de validade"
                                    id="input-data-validade">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Tipo de certificado: </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" readonly value="Tipo de certificado"
                                    id="input-tipo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-4 control-label">Certificado codificado em Base64: </label>
                        <div class="col-md-6">
                            <textarea type="text" rows="2" class="form-control" readonly value="" id="input-dados-certificado"
                                runat="server"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <br/><br/>
            <div class="row">
                    <h3>2º Passo:</h3>
                    <p>Clique no botão baixo para inicilizar a assinatura no Framework</p>
                </div>

            <div class="row">
                <div class="col-md-offset-4 col-md-4" style="text-align: center;">
                    <a href="#" class="btn btn-lg btn-primary"
                        onclick="BryApiModule.inicializar(); return false;">Inicializar assinatura (Server-Framework)</a>
                </div>
            </div>
            <div class="row">
                <h3>3º Passo:</h3>
                <p>Clique no botão baixo para assinar os dados utilizando a extensão</p>
            </div>

            <div class="btn-group" data-toggle="buttons">
                <a href="#json-entrada" class="btn btn-default" aria-expanded="false" aria-controls="collapseExample"
                    data-toggle="collapse"><input type="checkbox" autocomplete="off">Detalhes do JSON de entrada da
                    Extensão (Client-Side)</a>

            </div>
            <div class="collapse in" id="json-entrada">
                <div class="well" id="json-entrada-valor" style="word-wrap: break-word;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-offset-4 col-md-4" style="text-align: center;">
                    <a href="#" class="btn btn-lg btn-primary" onclick="BryApiModule.sign(); return false;">Assinar
                        com a Extensão (Client-Side)</a>
                </div>
            </div>
            <div class="row">
                <p>
                    <div class="alert alert-success" role="alert" id="success-message" style="display: none;">
                        <a type="button" class="close" aria-label="Close" onclick="$('#success-message').hide()"><span
                                aria-hidden="true">&times;</span></a>
                        Assinatura concluída com sucesso.
                    </div>
                </p>
                <p>
                    <div class="alert alert-warning" role="alert" id="error-message" style="display: none;">
                        <a type="button" class="close" aria-label="Close" onclick="$('#error-message').hide()"><span
                                aria-hidden="true">&times;</span></a>
                        Ocorreu algum erro. Mensagem: <span id="error-message-text"></span><br /> Informe este código
                        para o suporte: <span class="badge" id="codigo-de-erro"></span>.
                    </div>
                </p>
                <p>
                    <div class="alert alert-warning" role="alert" id="update_windows"
                        style="display: none; text-align: center">
                        <a type="button" class="close" aria-label="Close" onclick="$('#update_windows').hide()"><span
                                aria-hidden="true">&times;</span></a>
                        O Módulo da Extensão precisa ser atualizado<br /><a
                            onclick="BryApiModule.downloadNativeModuleWindows();" class="btn btn-success">Atualizar</a>
                    </div>
                    <div class="alert alert-warning" role="alert" id="update_linux"
                        style="display: none; text-align: center">
                        <a type="button" class="close" aria-label="Close" onclick="$('#update_linux').hide()"><span
                                aria-hidden="true">&times;</span></a>
                        O Módulo da Extensão precisa ser atualizado<br /><a
                            onclick="BryApiModule.downloadNativeModuleDeb();" class="btn btn-success">DEB</a> <a
                            onclick="BryApiModule.downloadNativeModuleRpm();" class="btn btn-success">RPM</a>
                    </div>
                </p>
            </div>

            <div class="btn-group" data-toggle="buttons">

                <a href="#json-saida" class="btn btn-default" aria-expanded="false" aria-controls="collapseExample"
                    data-toggle="collapse"><input type="checkbox" autocomplete="off" data-toggle="collapse">Detalhes
                    do JSON de saída da Extensão (Client-Side)</a>
            </div>
            <div class="collapse in" id="json-saida">
                <div class="well" id="json-saida-valor" style="word-wrap: break-word;">
                </div>
            </div>

            <div class="row">
                <h3>4º Passo:</h3>
                <p>Clique no botão baixo para finalizar a assinatura no Framework</p>
            </div>

            <div class="row">
                <div class="col-md-offset-4 col-md-4" style="text-align: center;">
                    <a href="#" class="btn btn-lg btn-primary"
                        onclick="BryApiModule.finalizar(); return false;">Finalizar assinatura (Server-Framework)</a>
                </div>
            </div>
            <br/>
            <div class="btn-group" data-toggle="buttons">
                <a href="#json-finaliza-fw" class="btn btn-default" aria-expanded="false" aria-controls="collapseExample"
                    data-toggle="collapse"><input type="checkbox" autocomplete="off" data-toggle="collapse">Detalhes
                    do JSON de retorno da Finalização (Server-Framework)</a>
            </div>
            <div class="collapse in" id="json-finaliza-fw">
                <textarea type="text" rows="10" class="form-control" readonly value="" id="json-finaliza-fw-valor"></textarea>
            </div>
            <br />
            <div style="padding-bottom: 75px"></div>
        </div> <!-- end extensao-instalada -->
        <div id="extensao-nao-instalada">
            <div class="container" style="text-align: center;">
                <div id="chrome-browser" class="row">
				</br>
                    <p>Exemplo Instalação Redirecionando para a Chrome WebStore </p>
					<p>Segue abaixo um exemplo de passo a passo para instruir o usuário na instalação da extensão</p>

					<p><strong>1º Passo -</strong> Clique no botão abaixo para acessar a Extensão no Chrome WebStore</strong></p>
					<a  onclick="BryApiModule.installExtension(); return false;" class="btn btn-lg btn-primary btn-extension-install">Instalar Extensão via Chrome WebStore!</a>
					<p><strong>2º Passo -</strong> Clique no botão <strong>USAR NO CHROME</strong></p>
					<img alt="Download" src="imgs/use_on_chrome_button.jpg">					
					<p><br/><br/><strong>3º Passo -</strong> Você deve retornar para esta página que ela será atualizada.</p>           
                </div>
                <div id="firefox-browser" class="row">
                    <h3 class="extension-message">Detectamos que a Extensão para Assinatura Digital não está instalada.</h3>
                    <p > Exemplo Instalação Inline. Para esta opção é necessário realizar o registro da extensão.</p>
                    <a onclick="BryApiModule.installExtension(); return false;" class="btn btn-lg btn-primary btn-extension-install">Instalar!</a><br/>
                </div>
                <div id="edge-browser">
                    <h3 class="extension-message">Lamentamos, mas uma versão da extensão só estará disponível para o seu navegador na próxima atualização!</h3>
                </div>
                <div id="opera-browser">
                    <h3 class="extension-message">Lamentamos, mas uma versão da extensão só estará disponível para o seu navegador na próxima atualização!</h3>
                </div>
                <div id="safari-browser">
					<br/><h3>Detectamos que a Extensão para Assinatura Digital não está instalada</h3><br/>
					<input type="image" width="250" weight="350" onclick="BryApiModule.installExtension(); return false;" src="imgs/baixar.png" /><br/><br/>
					<div class="centered">
					 <h4>Após a instalação é necessário habilitar a extensão nas preferências do Safari.</h4>
					 <p><b>1º Abra o aplicativo "BRy Assinatura Digital" instalado</b><br/> </p>
					 <strong>2º Dentro do aplicativo, clique em habilitar a extensão nas preferências do Safari</strong><br/>
					 
					 <img  src="imgs/app.png"/><br/>
					 <br/><strong>3º Marque a extensão como habilitada </strong><br/><br/>
					 <img src="imgs/ext.png"/><br/>
					 <p>Caso a opção para habilitar a extensão não apareça nas preferências do Safari, encerre o navagador, e repita o passo 2.
					 <br/><br/><strong>4º Após ativar a extensão, basta recarregar a página. </strong></p></div>
					 <a onclick="window.location.reload();" class="btn btn-lg btn-primary btn-extension-install">Recarregar página</a><br/>
                </div>
                <div id="ie-browser">
                    <h3 class="extension-message">Lamentamos, mas uma versão da extensão só estará disponível para o seu navegador na próxima atualização!</h3>
                </div>
                <div id="unknown-browser">
                    <h3 class="extension-message">Não foi possível identificar o seu browser!</h3>
                </div>
            </div>
        </div> <!-- end extensao-nao-instalada -->
    </div>

    <script src="cliente-master/js/jquery-3.2.1.min.js"></script>
    <script src="cliente-master/js/bootstrap.min.js"></script>
    <script src="cliente-master/js/script-customizavel.js"></script>
</body>

</html>