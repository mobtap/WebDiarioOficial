function salvar(form) {
    let dados = $(form).serializeArray().reduce((m, o) => {
        m[o.name] = o.value
        return m
    }, {})

    console.log(dados)

    $.post("salvar.php", dados, retorno => {
        if (typeof retorno == "object") {
            Swal.fire(
                '',
                retorno.message,
                retorno.status
            ).then(result => {
                if (result.value) {
                    if (retorno.redirect != "") {
                        window.location = retorno.redirect
                    }
                }
            })
        }
    })
}