var BryApiModule = (function () {
    var BryApiModule = {};

    // ################################################
    // TRECHO EDITADO DO ARQUIVO script-customizavel.js
    // ################################################

    BryApiModule.POST_exemple_using_XMLHttpRequest = function (url, formData) {
        // NOTA: Esta função ilustra a chamada POST para o serviço
        // Não está otimizada para executar em produção. Serve apenas como exemplo.
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.responseType = 'json';
            xhr.onload = function (e) {
                if (xhr.readyState == 4 && xhr.status == "200")
                    resolve(xhr.response);
                else
                    reject(xhr.response);
            }
            xhr.send(JSON.stringify(formData));
        });
    }

    BryApiModule.base64ToArrayBuffer = function (base64) {
        var binary_string = window.atob(base64);
        var len = binary_string.length;
        var bytes = new Uint8Array(len);
        for (var i = 0; i < len; i++) {
            bytes[i] = binary_string.charCodeAt(i);
        }
        return bytes.buffer;
    }

    BryApiModule.inicializar = async function () {
        $("#json-entrada-valor").text("");
        try {
            let url_FwInicializar = "http://localhost:8080/inicializar";
            let formData_FwInicializar = {
                "certificado": $("#input-dados-certificado").val()
            };
            let respInicializar = await BryApiModule.POST_exemple_using_XMLHttpRequest(url_FwInicializar, formData_FwInicializar);
            $("#json-entrada-valor").text(JSON.stringify(respInicializar));

        } catch (error) {
            alert(JSON.stringify(error));
        }
    }

    BryApiModule.finalizar = async function () {
        $("#json-finaliza-fw-valor").text("");
        try {
            let url_FwFinalizar = "http://localhost:8080/finalizar";
            let formData_FwFinalizar =  JSON.parse($("#json-saida-valor").text());
            let respFinicializar = await BryApiModule.POST_exemple_using_XMLHttpRequest(url_FwFinalizar, formData_FwFinalizar);
            $("#json-finaliza-fw-valor").text(JSON.stringify(respFinicializar));
        }
        catch (error) {
            alert(JSON.stringify(error));
        }
    }

    // ####################################################
    // FIM TRECHO EDITADO DO ARQUIVO script-customizavel.js
    // ####################################################

   /**
    * Variável Global que facilita o acesso aos certificados.
    * A função que lista os certificados preenche esta variável.
    * Dessa forma, será possível pegar os certificados desta variável sempre que precisar.
    */
   BryApiModule.certificates = [];

   /**
    * Sempre que a página é carregada é solicitado à extensão que busque
    * todos os certificados do usuário.
    */
   document.addEventListener("DOMContentLoaded", function () {
       if ( BryApiModule.isExtensionInstalled() ) {
           $("#extensao-instalada").show();
           $("#extensao-nao-instalada").hide();

           BryApiModule.listCertificates();
       } else {
           $("#extensao-instalada").hide();
           $("#extensao-nao-instalada").show();
           detectBrowser();
       }
   });

   /**
    * Verifica se a extensão está instalada.
    * @return true para instalada, false para não instalada.
    */
   BryApiModule.isExtensionInstalled = function () {
       if ( typeof BryExtension !== "undefined" && typeof BryExtension.listCertificates === "function" )
           return true;
       else
           return false;
   }

   /**
    * Está função é (Opcional) porque a extensão verifica automaticamente 
    * se o módulo está atualizado e instrui o usuário a realizar o download 
    * do módulo da extensão.
    * 
    * Esta função é utilizada neste exemplo para exibir um botão de download
    * do módulo da extensão na página.
    */
   BryApiModule.isNativeModuleUpdated = function () {
       // Função da extensão
       BryExtension.isNativeModuleUpdated()
       .then(function(isUpdated){
           if (isUpdated) {
               $("#update_windows").hide();
               $("#update_linux").hide();
               $("#update_macos").hide();
               $("#success-message").hide();
           } else {
               if (navigator.platform === "Win32" || navigator.platform === "Win64") {
                   $("#update_windows").show();
                   $("#update_linux").hide();
                   $("#update_macos").hide();
               } else if(navigator.platform.toLowerCase().search(/mac/i) > -1) {
                   $("#update_windows").hide();
                   $("#update_linux").hide();
                   $("#update_macos").show();
               } 
               else {
                   $("#update_linux").show();
                   $("#update_windows").hide();
                   $("#update_macos").hide();
               }
               $("#success-message").hide();
           }
       })
       .catch(function(error){
           // Do Nothing!
       });
   }

   /**
   * Função utilizada para listar os certificados na máquina do usuário.
   * Essa função redireciona a chamada para a extensão e configura o campo de certificados.
   */
   BryApiModule.listCertificates = function () {
       // Função da extensão
       BryExtension.listCertificates()
       .then(function(certificates){
           BryApiModule.updateCertificates(certificates);
       })
       .catch(function(error){
           $("#codigo-de-erro").html(error.key);
           $("#error-message-text").text(error.description);
           $("#error-message").show();
           $("#success-message").hide();
           $("#update").hide();
       });
   }
   
   /**
   * Função utilizada para atualizar o combo de certificados. Antes de popular o combo esta função
   * aplica um conjunto de filtros.
   *
   * @param {Array} certificates - Detalhes sobre os campos do certificado estão na documentação.
   */
   BryApiModule.updateCertificates = function (certificates) {
       BryApiModule.certificates = BryApiModule.filter(certificates);
       BryApiModule.fillCertificateSelect(BryApiModule.certificates);
   }
   
   /**
    * Essa função é responsável por popular o elemento "select" na página
    * que o usuário utiliza para indicar qual o certificado deseja utilizar
    * para produzir a assinatura digital.
    *
    * Será utilizado as propriedades "nome" e "certId" do certificado. Posteriormente,
    * será possível pegar o "certId" do certificado selecionado e consultar a variável
    * global de certificados para pegar os bytes do certificado.
    *
    * @param {Array} certificates
    */
   BryApiModule.fillCertificateSelect = function (certificates) {
       var element = document.getElementById("select-certificado-list");
       element.innerHTML = "";

       var hasCertificateAvailable = certificates.length > 0;
       if (hasCertificateAvailable) {
           for (var i = 0; i < certificates.length; i++) {
               var certificate = certificates[i];
               var option = document.createElement("option");
               option.value = certificate.certId;
               option.innerHTML = certificate.name;
               element.appendChild(option);
           }
       } else {
           var option = document.createElement("option");
           option.text = "Nenhum certificado disponivel";
           element.add(option);
       }

       BryApiModule.fillCertificateDataForm();
   }

   /**
   * Realiza o processo de assinatura do input de entrada.
   *
   * É necessário informar o "certId" do certificado e os dados de entrada.
   * Para entender os dados de entrada do processo de assinatura favor consultar a documentação.
   */
   BryApiModule.sign = function () {
       // Limpa o json de saída, setando "" string vazia a cada requisição.
       document.getElementById("json-saida-valor").innerHTML = "";

       var input = $("#json-entrada-valor").text();
       var element = document.getElementById("select-certificado-list");
       var idSelectedCertificate = element.value;

       // Função da extensão
       BryExtension.sign(idSelectedCertificate, input)
           .then(function(response){
               BryApiModule.processSignatures(response);
           })
           .catch(function(error){
               $("#codigo-de-erro").html(error.key);
               $("#error-message-text").text(error.description);
               $("#error-message").show();
               $("#success-message").hide();
               $("#update").hide();
           });
   }

   /**
    * Essa função é chamada sempre que a página recebe devolta os
    * dados processados da assinatura. Esses dados precisam ser devolvidos
    * ao servidor para que a assinatura seja completada. Os dados
    * produzidos pela extensão são colocados em um "input" e então
    * o servidor é notificado que esses dados estão prontos.
    *
    * @param {Object} data - dados produzidos pela extensão.
    * Consulte a documentação do desenvolvedor.
    */
   BryApiModule.processSignatures = function (data) {
       $("#json-saida-valor").text(JSON.stringify(data));
       $("#success-message").show();
       $("#error-message").hide();
       $("#update").hide();
   }

   /**
    * Essa função é chamada sempre que o usuário altera sua opção de
    * qual certificado deseja utilizar.
    * Consulta a variável global de certificados para pegar informações do
    * certificado selecionado.
    */
   BryApiModule.fillCertificateDataForm = function () {
       var element = document.getElementById("select-certificado-list");
       var selected = element.value;

       var certificate = null;
       for (var i = 0; i < BryApiModule.certificates.length; i++) {
           if (BryApiModule.certificates[i].certId === selected) {
               certificate = BryApiModule.certificates[i];

               $("#input-nome").val(certificate.name);
               $("#input-emissor").val(certificate.issuer);
               $("#input-data-validade").val(certificate.expirationDate);
               $("#input-tipo").val(certificate.certificateType);
               $("#input-dados-certificado").val(certificate.certificateData);
               
               break;
           }
       }
   }

   /**
   * Configurações utilizadas no momento que os filtros são aplicados.
   */
   BryApiModule.filters = {
       ROOT_CA: 0, // 0=Todos os certificados, 1=Somente Confiáveis, 2=Somente ICP-Brasil
       CNPJS: [], // ex.: ["CNPJ1","CNPJ2"]
       CPFS: [], // ex.: ["CPF","CPF2"]
       CERTIFICATE_TYPE: [], // ex.: ["A1","A2","A3"]
       SHOW_EXPIRED: true
   }

   /**
    * Função responsável pela aplicação dos filtros. Essa função aplica
    * uma série de filtros aos certificados recebidos. Esses filtros são
    * aplicados um após o outro e apenas os certificados que satisfizerem
    * todos os filtros são retornados.
    *
    * @param {Array} certificates - certificados que serão filtrados.
    * @returns {Array} os certificados que satisfizeram todos os filtros.
    * Consulte a documentação do desenvolvedor.
    */
   BryApiModule.filter = function (certificates) {
       let filtered = BryApiModule.filterByCpf(certificates);
       filtered = BryApiModule.filterByCnpj(filtered);
       filtered = BryApiModule.filterByType(filtered);
       filtered = BryApiModule.filterExpired(filtered);
       filtered = BryApiModule.filterByRootCA(filtered);
       return filtered;
   }

   /**
    * Filtra os certificados através de uma lista de CPFs.
    *
    * @param {Array} certificates - Os certificados que devem ser filtrados
    * Consulte a documentação do desenvolvedor.
    */
   BryApiModule.filterByCpf = function (certificates) {
       var cpfs = BryApiModule.filters.CPFS;
       if( cpfs.length > 0 )
           return certificates.filter(function (certificate){
               return cpfs.find(function (cpf) {
                   return onlyNumbers(cpf) === onlyNumbers(certificate.cpf);
               });
           });
       else
           return certificates;
   }

   /**
    * Filtra os certificados através de uma lista de CNPJs.
    *
    * @param {Array} certificates - Os certificados que devem ser filtrados
    * Consulte a documentação do desenvolvedor.
    */
   BryApiModule.filterByCnpj = function (certificates) {
       var cnpjs = BryApiModule.filters.CNPJS;
       if( cnpjs.length > 0 )
           return certificates.filter(function (certificate){
               return cnpjs.find(function (cnpj) {
                   return onlyNumbers(cnpj) === onlyNumbers(certificate.cnpj);
               })
           });
       else
           return certificates;
   }

   /**
    * Filtro baseado no tipo do certificado.
    *
    * @param {Array} certificates - Os certificados que devem ser filtrados
    */
    BryApiModule.filterByType = function (certificates) {
        var types = BryApiModule.filters.CERTIFICATE_TYPE;
        if( types.length > 0 )
            return certificates.filter(function (certificate) {
                return types.find(function (type) {
                    return type === certificate.certificateType;
                })
            });
        else
            return certificates;
    }

   /** Habilita/desabilita a exibição de certificados expirados.
    * @param {Array} certificates - Os certificados que devem ser filtrados
   */
   BryApiModule.filterExpired = function (certificates) {
       if (BryApiModule.filters.SHOW_EXPIRED === false) {
           for (var i = certificates.length - 1; i >= 0; --i) {
               if (certificates[i].validity.localeCompare("VALID") != 0 && certificates[i].validity.localeCompare("INVALID_INCOMPLET_CHAIN") != 0 )
                   certificates.splice(i, 1);
           }
       }
       return certificates;
   }

   /** Habilita/desabilita a exibição de certificados expirados.
    * @param {Array} certificates - Os certificados que devem ser filtrados
   */
   BryApiModule.filterByRootCA = function (certificates) {
       //0 é o comportamento padrão, ou seja, sem filtro
       var selectedValue = BryApiModule.filters.ROOT_CA;

       //Remove os certificados que não são confiáveis
       if (selectedValue == 1) {
           for (var i = certificates.length - 1; i >= 0; --i) {
               if (!certificates[i].trusted) certificates.splice(i, 1);
           }
       //Remove os certificados que não são ICP-Brasil
       } else if (selectedValue == 2) {
           for (var i = certificates.length - 1; i >= 0; --i) {
               if (!certificates[i].icpBrasil) certificates.splice(i, 1);
           }
       }

       return certificates;
   }

   /**
    * Remove todos os dígitos não-numéricos do campo informado
    * @param {any} field campo com o texto que deverá ser tratado
    * @returns {string} string contendo apenas os digitos númericos
    */
   function onlyNumbers(field) {
       return field.replace(/^\D+/g, '');
   }

   /**
    * Transforma a string de data retornada pela extensão em um objeto Date do javascript.
    * @param {any} date O formato esperado dessa string é "dd/MM/yyyy HH:mm:ss".
    * @returns {Date} objeto Date configurado com a data transformada da string.
    */
   function parseDate(date) {
       var slicedDate = date.split(" ");
       var dayMothYear = slicedDate[0].split("/");
       var hourMinuteSecond = slicedDate[1].split(":");
       return new Date(dayMothYear[2], dayMothYear[1] - 1, dayMothYear[0],
           hourMinuteSecond[0], hourMinuteSecond[1], hourMinuteSecond[2]);
   }

   /**
    * Funções simplificadas para detecção do browser, modifique se achar necessário
    */
   function isOpera() {
       return !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
   }

   function isFirefox() {
       return typeof InstallTrigger !== 'undefined';
   }

   function isSafari() {
       return navigator.userAgent.indexOf("Safari") > -1
   }

   function isIE() {
       return /*@cc_on!@*/ false || !!document.documentMode;
   }

   function isEdge() {
       if (document.documentMode || /Edge/.test(navigator.userAgent)) {
           return true;
       }
       else {
           return false;
       }
   }

   function isChrome(){
       return /Google Inc/.test(navigator.vendor);
   }

   function detectBrowser() {
       $("#chrome-browser").hide();
       $("#firefox-browser").hide();
       $("#opera-browser").hide();
       $("#edge-browser").hide();
       $("#safari-browser").hide();
       $("#ie-browser").hide();
       $("#unknown-browser").hide();
       if(isChrome()){
           $("#chrome-browser").show();
       }
       else if (isFirefox())
       {
           $("#firefox-browser").show();
       }
       else if (isEdge())
       {
           $("#edge-browser").show();
       }
       else if (isOpera())
       {
           $("#opera-browser").show();
       }
       else if (isSafari())
       {
           $("#safari-browser").show();
       }
       else if (isIE())
       {
           $("#ie-browser").hide();
       }
       else
       {
           $("#unknown-browser").hide();
       }
   }

   BryApiModule.installExtension = function () {
       if(isChrome())
       {
           window.addEventListener('focus', () => window.location.reload());
           window.open("https://chrome.google.com/webstore/detail/dhikfimimcjpoaliefjlffaebdeomeni");
       }
       else if(isSafari()) {
           window.open("https://itunes.apple.com/br/app/bry-assinatura-digital/id1315721873?mt=12", "_blank");
       }
       else
       {
           promptDownload("https://www.bry.com.br/downloads/extension/firefox/assinatura_digital_bry.xpi");
           function timeout() {
               setTimeout(function () {
                  if(BryApiModule.isExtensionInstalled()){
                   window.location.reload();
                  }
                   timeout();
               }, 1000);
           }
           timeout();
       }
       
   }

   /**
   * Essa função faz a chamada para download do módulo nativo do Windows.
   * Observe a página de exemplo html que direciona o botão de download da atualização para esta função.
   */
   BryApiModule.downloadNativeModuleWindows = function () {
       BryExtension.getNativeModuleUrl("windows").then(function (url) {
           promptDownload(url);
       })
       .catch(function (error) {
       $("#codigo-de-erro").html(error.key);
       $("#error-message-text").text(error.description);
       $("#error-message").show();
       $("#success-message").hide();
       $("#update").hide();
       });
   }

   /**
   * Essa função faz a chamada para download do modulo nativo no Linux, distribuições baseadas em Debian (Ubuntu, Mint).
   * A função verifica a arquitetura do sistema operacional e faz a chamada para 32 ou 64 bits.
   * Observe a página de exemplo html que direciona o botão de download da atualização para esta função.
   */
   BryApiModule.downloadNativeModuleDeb = function () {
       if (navigator.platform.search("x86_64") > -1) {
           BryExtension.getNativeModuleUrl("linux_deb_amd64").then(function (url) {
               promptDownload(url);
           })
           .catch(function (error) {
               $("#codigo-de-erro").html(error.key);
               $("#error-message-text").text(error.description);
               $("#error-message").show();
               $("#success-message").hide();
               $("#update").hide();
           });
       } else {
           BryExtension.getNativeModuleUrl("linux_deb_i686").then(function (url) {
               promptDownload(url);
           })
           .catch(function (error) {
               $("#codigo-de-erro").html(error.key);
               $("#error-message-text").text(error.description);
               $("#error-message").show();
               $("#success-message").hide();
               $("#update").hide();
           });
       }
   }

   /**
   * Essa função faz a chamada para download do módulo nativo do macOS.
   * Observe a página de exemplo html que direciona o botão de download da atualização para esta função.
   */
   BryApiModule.downloadNativeModuleMacOS = function () {
       BryExtension.getNativeModuleUrl("macos").then(function (url) {
           promptDownload(url);
       })
       .catch(function (error) {
       $("#codigo-de-erro").html(error.key);
       $("#error-message-text").text(error.description);
       $("#error-message").show();
       $("#success-message").hide();
       $("#update").hide();
       });
   }

   /**
   * Essa função faz a chamada para download do modulo nativo no Linux, distribuições baseadas em Redhat (Fedora, OpenSuse).
   * A função verifica a arquitetura do sistema operacional e faz a chamada para 32 ou 64 bits.
   * Observe a página de exemplo html que direciona o botão de download da atualização para esta função.
   */
   BryApiModule.downloadNativeModuleRpm = function () {
       if (navigator.platform.search("x86_64") > -1) {
           BryExtension.getNativeModuleUrl("linux_rpm_amd64").then(function (url) {
               promptDownload(url);
           })
           .catch(function (error) {
               $("#codigo-de-erro").html(error.key);
               $("#error-message-text").text(error.description);
               $("#error-message").show();
               $("#success-message").hide();
               $("#update").hide();
           });
       } else {
           BryExtension.getNativeModuleUrl("linux_rpm_i686").then(function (url) {
               promptDownload(url);
           })
           .catch(function (error) {
               $("#codigo-de-erro").html(error.key);
               $("#error-message-text").text(error.description);
               $("#error-message").show();
               $("#success-message").hide();
               $("#update").hide();
           });
       }
   }

   /**
    * Faz o download do arquivo indicado na url
    *
    * @param {string} url url do arquivo que deve ser baixado.
    */
   function promptDownload(url) {
       var elementDownload = document.createElement("a");
       elementDownload.setAttribute('href', url);

       elementDownload.style.display = 'none';
       document.body.appendChild(elementDownload);

       elementDownload.click();

       document.body.removeChild(elementDownload);
   }

   return BryApiModule;
})();
