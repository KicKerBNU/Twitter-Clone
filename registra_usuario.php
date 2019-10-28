<?php

require_once('db.class.php');
$usuario = $_POST['usuario'];
$email = $_POST['email'];
$senha = md5($_POST['senha']);

$objDb = new db();
$link = $objDb->conecta_mysql();

$usuario_exsite = false;
$email_existe = false;

//verificar se o usuario existe
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
if($resultado_id = mysqli_query($link,$sql)){
    $dados_usuario = mysqli_fetch_array($resultado_id);

    if(isset($dados_usuario['usuario'])){
        $usuario_existe = true;
    }   
}else{
    echo "Erro ao encontrar o registro do usuario";
}

//verificar se o email existe
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
if($resultado_id = mysqli_query($link,$sql)){
    $dados_usuario = mysqli_fetch_array($resultado_id);

    if(isset($dados_usuario['email'])){
        $email_existe = true;
    }
}else{
    echo "Erro ao encontrar o registro do email";
}

if($usuario_existe || $email_existe){
    
    $retorno_get = "";

    if($usuario_existe){
        $retorno_get.= "erro_usuario=1&";
    }
    if($email_existe){
        $retorno_get.= "erro_email=1&";
    }
    
    header("Location: inscrevase.php?".$retorno_get);
    die();
}


//adicionando usuario novo no banco
$sql = "insert into usuarios(usuario, email, senha) values ('$usuario','$email','$senha')";

//Executar a query
if (mysqli_query($link, $sql)){
    echo 'Usuario adicionado com sucesso!';
}else{
    echo 'Erro ao adicionar o usuario';
};
?>