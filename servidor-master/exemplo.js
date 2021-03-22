const request = require('request');
const fs = require('fs');
require('dotenv/config');

// É necessário armazenar o nonce do lote inicializado
// para que seja possível finalizar a assinatura
var nonceSessaoLotePdfInicializado = "";

var credencial = `${process.env.ACCESS_TOKEN}`;

const inicializar = (req, resp) => {
 
    console.log(credencial);
    let bodyJson = JSON.parse(req.body);

    // Certificado veio do lado cliente
    let certificado = bodyJson.certificado;

    // Inicializa assinatura PDF (Server-Framework através do BRy HUB)
    inicializarPdf(certificado)
    .then((resultPdf) => {

		// Prepara os dados de entrada para a extensão e envia para o lado cliente
		let input = prepararDadosEntradaExtensao(JSON.parse(resultPdf));

		resp.status(200).send(input);

    })
    .catch((error) => {
        resp.status(400).send(error);
    });
}

const finalizar = (req, resp) => {
    let resultadoExtensao = JSON.parse(req.body);

    let dadosFinalizarPdf = [];

    // Prepara os dados para finalizar a assinatura
    for (let i = 0; i < resultadoExtensao.assinaturas.length; i++) {
		dadosFinalizarPdf.push({
			"cifrado": resultadoExtensao.assinaturas[i].hashes[0],
			"nonce": resultadoExtensao.assinaturas[i].nonce
		});
    }

    // Finaliza assinatura PDF (Server-Framework através do BRy HUB)
    finalizarPdf(dadosFinalizarPdf)
    .then((resultPdf) => {

		// Cria uma estrutura JSON apenas para exibir no textarea no lado cliente
		var input = {
			"PDF": resultPdf
		};

		resp.status(200).send(input);

    })
    .catch((error) => {
        resp.status(400).send(error);
    });
}

// Esta função prepara os dados para a extensão assinar.
function prepararDadosEntradaExtensao(resultPDf) {
    // Para mais detalhes sobre os dados de entrada da extensão favor consular a documentação da extensão.  

    nonceSessaoLotePdfInicializado = resultPDf.nonce;

    let assinaturas = new Array();

    for (let i = 0; i < resultPDf.assinaturasInicializadas.length; i++) {
        assinaturas.push({
            "algoritmoHash": resultPDf.algoritmoHash,
            "nonce": resultPDf.assinaturasInicializadas[i].nonce,
            "hashes": [resultPDf.assinaturasInicializadas[i].messageDigest]
        });
    }

    let input = {        
        "formatoDadosEntrada": "Base64",
        "formatoDadosSaida": "Base64",
        "assinaturas": assinaturas
    };
    
    return JSON.stringify(input);
}

function inicializarPdf(certificado) {
    var formData = {
        // loop
        'documento': [
            fs.createReadStream("./documento.pdf"),
            fs.createReadStream("./documento.pdf")
        ],
        // fim loop
        'imagem': fs.createReadStream("./imagem.jpg"),
        'dados_inicializar': JSON.stringify(
            {
                "perfil": "CARIMBO",
                "algoritmoHash": "SHA256",
                "formatoDadosEntrada": "Base64",
                "formatoDadosSaida": "Base64",
                "certificado": certificado,
                "nonces": ["PDF1","PDF2"]
            }
        ),
        'configuracao_imagem': JSON.stringify(
            {
                "altura": 60,
                "largura": 170,
                "posicao": "INFERIOR_ESQUERDO",
                "pagina": "PRIMEIRA"
            }
        )
    };

    const options = {
        method: "POST",
        url: `https://${process.env.URL_HUB}/fw/v1/pdf/pkcs1/assinaturas/acoes/inicializar`,
        port: 443,
        headers: {
            "Authorization": credencial,
            "Content-Type": "multipart/form-data"
        },
        formData: formData
    };

    return new Promise((resolve, reject) => {
        request.post(options, (err, res, body) => {
            if (err) {
                console.log(err);
                reject(err);
            }
            else {
                if (res.statusCode == 200) {          
                    resolve(body);
                }
                else {
                    reject(body);
                }
            }
        });
    });
}

function finalizarPdf(dataFinalizaPdf) {
    let jsonFinalizar = {
        "nonce": nonceSessaoLotePdfInicializado,
        "formatoDeDados": "Base64",
        "assinaturasPkcs1": dataFinalizaPdf
    };

    const options = {
        method: "POST",
        url: `https://${process.env.URL_HUB}/fw/v1/pdf/pkcs1/assinaturas/acoes/finalizar`,
        port: 443,
        headers: {
            "Authorization": credencial,
            "Content-Type": "application/json"
        },
        json: jsonFinalizar
    };

    return new Promise((resolve, reject) => {
        request.post(options, (err, res, body) => {
            if (err) {
                console.log(err);
                reject(err);
            }
            else {
                if (res.statusCode == 200) {       
                    resolve(body);
                }
                else {
                    reject(body);
                }
            }
        });
    });
}

function objToBase64(data) {
    // Função não otimizada, para fins de exemplo
    let buff = Buffer.from(data);
    return buff.toString('base64');
}

module.exports = {
    inicializar,
    finalizar
}
