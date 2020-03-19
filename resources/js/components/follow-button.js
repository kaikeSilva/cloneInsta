import React from 'react';
import ReactDOM from 'react-dom';

/*
    COMPONENTE
    Criação de tags html personalizadas
    Colocar o id com o nome da função na tag e ela sera o retorno do html da função

    Para que o projeto seja recompilado automaticamente sempre que houver mudanças
    executar: npm run watch
*/



function Example() {
    var classes
    var textoDoBotao
    /*
        COMUNICAÇÃO DO FRONT COM API
    */
    //laravel contem uma library chamada axius que permite fazer call na api
    function seguir(){
        let $userid = document.getElementById('example').getAttribute('userid')
        //console.log(`/follow/${$userid}`)
        axios.post(`/follow/${$userid}`)
        .then(response => {
            console.log(response.status)
            location.reload()
        })
        .catch((error) => {
            //tratamento de excessão do axios
            //se a resposta for 401 significa que o usuário não tem permissão
            //isso ocorre por estar deslogado e tentar seguir alguem
            //redireciona-lo para a página de login
            //console.log(error.response.status)
            if (error.response.status == 401) {
                window.location.replace('http://127.0.0.1:8000/login')
            }
        });

    }

    //mudar o valor do botão de acordo com o status de seguidor
    function follow() {
        //função para retornar se o usuário ja segue ou não o perfil que esta visitando
        let status = document.getElementById('example').getAttribute('follows')
        console.log(status)
        if(status) {
            classes = "btn-danger ml-4 btn-sm"
            textoDoBotao = "Unfollow"
        } else {
            classes = "btn-primary ml-4 btn-sm"
            textoDoBotao = "follow"
        }
    }

    follow() 
    //console.log(classes)

    return (
        <div className="container">
            <button  onClick={seguir} className={classes} >{textoDoBotao}</button>
        </div>
    );
}

export default Example;

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
