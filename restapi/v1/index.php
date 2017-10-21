<?php
/**
 *
 * @About:      REST API which store people and their contacts
 * @File:       index.php
 * @Date:       $Date:$ Oct-2017
 * @Version:    $Rev:$ 1
 * @Developer:  Luis Prado
 **/


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 

include_once '../include/Config.php';
require_once '../include/DbHandler.php'; 

require '../libs/Slim/Slim.php'; 
\Slim\Slim::registerAutoloader(); 
$app = new \Slim\Slim();


/* #########################################*/
/* 1) MÉTODO GET PARA OBTER LISTA DE PESSOAS*/ 
/* #########################################*/
// TESTE:     http://localhost/restapi/v1/person/all
// METODO: GET
// RESULTADO: Mostra todas as pessoas na tabela.

// TESTE:  http://localhost/restapi/v1/person/8894632
// RESULTADO: Mostra  o registro do id indicado.

$app->get('/person/:id', function($id) use ($app){
    
    $response = array();
    $db = new DbHandler();

    
    $personas=$db->consultarPersona($id);
        
    $response["error"] = false;
    $response["message"] = "Pessoas carregadas: " . count($personas); 
    $response["personas"] = $personas;

    echoResponse(200, $response);
});


/* #############################################*/
/* 2) MÉTODO POST PARA CRIAR O REGISTO DE PESSOA*/
/* #############################################*/
/* TESTE:     http://localhost/restapi/v1/person
// METODO: POST
// OBSERVAÇÃO:
   O POST DEVE TER AS KEYS: 
        -id
        -nombre
        -apellido
        -email
        -direccion
        -telefono
        -website

 RESULTADO: Cria um registro na tabela de pessoas
*/
$app->post('/person', function() use ($app){

    $db = new DbHandler();    
    $param['id']  = $app->request->post('id');
    $param['nombre']  = $app->request->post('nombre');
    $param['apellido']  = $app->request->post('apellido'); //sobrenome
    $param['email']  = $app->request->post('email');
    $param['direccion']  = $app->request->post('direccion');
    $param['telefono']  = $app->request->post('telefono');
    $param['website']  = $app->request->post('website');
    $resp=$db->insertarPersona($param);
    if($resp["erro"] == false){ //sem erro
             echoResponse(200, $resp);
    }else{
             echoResponse($resp["codigo_erro"], $resp);
    }
});


/* #########################################*/
/* 3) MÉTODO DELETE PARA ELIMINAR UMA PESSOA*/
/* #########################################*/
// TESTE:  http://localhost/restapi/v1/person/8894632
// METODO: DELETE
// RESULTADO: Elimina  o registro do id indicado.
$app->delete('/person/:id', function($id) use ($app){

    $db = new DbHandler();    
    $resp=$db->eliminarPersona($id);
    if($resp["erro"] == false){ //sem erro
             echoResponse(200, $resp);
    }else{
             echoResponse($resp["codigo_erro"], $resp);
    }        
   
});

/* #########################################*/
/* 4) METODO PUT PARA ACTUALIZAR UMA PESSOA */
/* #########################################*/
/* TESTE:     http://localhost/restapi/v1/person/889516
// METODO: PUT
// OBSERVAÇÃO:
   O POST DEVE TER AS KEYS  (X-WWW-FORM-URLENCODED): 
        -nombre
        -apellido
        -email
        -direccion
        -telefono
        -website

 o número no uri significa o id da pessoa
 RESULTADO: Actualiza completamente um registro na tabela de pessoas
*/
$app->put('/person/:id', function($id) use ($app){
    $db = new DbHandler();    
    $param['id']  = $id;
    $param['nombre']  = $app->request->post('nombre');
    $param['apellido']  = $app->request->post('apellido');
    $param['email']  = $app->request->post('email');
    $param['direccion']  = $app->request->post('direccion');
    $param['telefono']  = $app->request->post('telefono');
    $param['website']  = $app->request->post('website');
    $resp=$db->actualizarPersona($param);
    if($resp["erro"] == false){ //sem erro
             echoResponse(200, $resp);
    }else{
             echoResponse($resp["codigo_erro"], $resp);
    } 
   
   
});

/* ##########################################*/
/* 1) METODO GET PARA OBTER LISTA DE CONTATOS*/
/* ##########################################*/
// TESTE:     http://localhost/restapi/v1/contact/all
// METODO: GET
// RESULTADO: Mostra todas os contatos na tabela.

// TESTE:  http://localhost/restapi/v1/contact/1
// RESULTADO: Mostra  o registro do id indicado.
// NOTA: Na tabela de contato, o ID é um serial

$app->get('/contact/:id', function($id) use ($app){
    
    $response = array();
    $db = new DbHandler();
   
    $contactos=$db->consultarContacto($id);
        
    $response["error"] = false;
    $response["message"] = "Contatos carregados: " . count($contactos); 
    $response["contatos"] = $contactos;

    echoResponse(200, $response);
});


/* #########################################*/
/* 2) METODO POST PARA CRIAR UM CONTATO     */
/* #########################################*/
/* TESTE:     http://localhost/restapi/v1/contact
// METODO: POST
// OBSERVAÇÃO:
   O POST DEVE TER AS KEYS: 
        -id_persona
        -tipo
        -valor
  
 RESULTADO: Cria um registro na tabela de contatos
*/
$app->post('/contact', function() use ($app){

    $db = new DbHandler();    
    $param['id_persona']  = $app->request->post('id_persona');
    $param['tipo']  = $app->request->post('tipo'); //tipo de contato: telefone, e-mail, whatsapp, etc.
    $param['valor']  = $app->request->post('valor');

    $resp=$db->insertarContacto($param);
    if($resp["erro"] == false){ //sem erro
             echoResponse(200, $resp);
    }else{
             echoResponse($resp["codigo_erro"], $resp);
    }
});

/* #########################################*/
/* 3) METODO DELETE PARA REMOVER UM CONTATO */
/* #########################################*/
// TESTE:  http://localhost/restapi/v1/contac/3
// METODO: DELETE
// RESULTADO: Elimina  o registro do id indicado.
$app->delete('/contact/:id', function($id) use ($app){

    $db = new DbHandler();    
    $resp=$db->eliminarContacto($id);
    if($resp["erro"] == false){ //sem erro
             echoResponse(200, $resp);
    }else{
             echoResponse($resp["codigo_erro"], $resp);
    }        
   
});
/* #########################################*/
/* 4) METODO PUT PARA ACTUALIZAR UM CONTATO */
/* #########################################*/
/* TESTE:     http://localhost/restapi/v1/contact/2
// METODO: PUT
// OBSERVAÇÃO:
   O POST DEVE TER AS KEYS  (X-WWW-FORM-URLENCODED): 
        -id_persona
        -tipo
        -valor

 o número no uri significa o id da contato
 RESULTADO: Actualiza completamente um registro na tabela de contato
*/
$app->put('/contact/:id', function($id) use ($app){
    $db = new DbHandler();    
    $param['id']  = $id;
    $param['id_persona']  = $app->request->post('id_persona');
    $param['tipo']  = $app->request->post('tipo');
    $param['valor']  = $app->request->post('valor');

    $resp=$db->actualizarContacto($param);
    if($resp["erro"] == false){ //sem erro
             echoResponse(200, $resp);
    }else{
             echoResponse($resp["codigo_erro"], $resp);
    } 
   
   
});
/* #####################################################################################*/


/* corremos o aplicativo */
$app->run();

/*********************** FUNÇÕES DE UTILIDADE **************************************/
 

function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // código de resposta Http 
    $app->status($status_code);
 
    // definindo o tipo de conteúdo da resposta json
    
    $app->contentType('application/json');
 
    echo json_encode($response);
}

?>