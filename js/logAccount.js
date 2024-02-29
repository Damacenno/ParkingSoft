function loging() {

    var loginE = $("input[name='login']").val();
    var senhaE = $("input[name='senha']").val();

    changeLoad("flex");

    $.ajax({
        url: "func/logAccount.php",
        type: "POST",
        data: { login: loginE, senha: senhaE },
        datatype: "json",

    }).done(function (resposta) {
        console.log(resposta);
        switch (resposta) {
            case "401":
                changeLoad("none");
                alert("Login não encontrado");
                break;
            case "203":
                changeLoad("none");
                alert("Senha incorreta");
                break;
            case "200":
                changeLoad("none");
                window.location.assign('pages/home.php');
                break;
                default:
                    changeLoad("none");
                    alert("Contate um administrador");
                    break;
        }
    }).fail(function (textStatus) {
        console.log("Request failed: " + textStatus);
    });

}

function changeLoad(state){
    document.getElementById("loading").style.display = state;
}

