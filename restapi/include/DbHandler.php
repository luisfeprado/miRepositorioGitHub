<?php
/** 
 * @About:      Classe que lida com tudo referente ao banco de dados
 * @Date:       $Date:$ Oct-2017
 * @Version:    $Rev:$ 1
 * @Developer:  Luis Prado
 **/
class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DbConnect.php';
        // abrindo a conexão ao bd
        $db = new DbConnect();
        $this->conn = $db->connect();
    } 
/*###############################################################*/    
/*################ FUNÇÕES RELATIVAS À PESSOAS ##################*/
/*###############################################################*/
     public function consultarPersona($id){
      // FUNÇÃO PARA O GET. CONSULTA A TABELA "PESSOAS" POR ID
      // SE LHE PASSA A PALAVRA "ALL" RETORNA TODOS OS REGITROS
        $sql = "SELECT * FROM person where id=".($id != 'all'?$id:'id');

        $resultado = $this->conn->query($sql);
       
        $personas=Array();
        $i=0;
        if($resultado->rowCount()>0){
            foreach ($resultado as $fila) {                
                       $personas[$i]=array('id'=>$fila['id'],
                                           'Nombre'=>$fila['name'], 
                                           'Apellido'=>$fila['surname'], 
                                           'email'=>$fila['email'],
                                           'Direccion'=>$fila['address'],
                                           'Teléfono'=>$fila['phone'],
                                           'Website'=>$fila['website']);
                       $i++;
                     }

        } 
        return $personas;
    }
    public function insertarPersona($param){
       // FUNÇÃO PARA O POST.CRIE UM NOVO REGISTO NA TABELA "PESSOAS"
        try{
           if($param['id'] != null && $param['id'] != "") {
              $sentencia = $this->conn->prepare("INSERT INTO person (id,name,surname,email,address,phone,website) VALUES (?,?,?,?,?,?,?)");
              $sentencia->execute(array($param['id'],
                                        $param['nombre'], 
                                        $param['apellido'],
                                        $param['email'],
                                        $param['direccion'],
                                        $param['telefono'],
                                        $param['website']));
              $response["erro"] = false;            
              $response["mensagem"] = "A pessoa foi adicionada corretamente !";  
            }else{
                $response["erro"] = true;            
                $response["codigo_erro"] = 999;            
                $response["mensagem"] = "Você deve incluir o ID da pessoa !";                 
            }            
        }
        catch (Exception  $e) {     
            $response["erro"] = true;
            $response["codigo_erro"] = $e->getCode();
            $response["mensagem"] = $e->getMessage();             
        }
        return $response;
    }
    public function eliminarPersona($id){    
      // FUNÇÃO PARA O DELETE. REMOVE UM REGISTO NA TABELA "PESSOAS"
        try{

          if($id != null && $id != "") {
                $sql = "SELECT * FROM person where id=$id";
                $resultado = $this->conn->query($sql);

                if($resultado->rowCount()>0){
                  $sentencia = $this->conn->prepare("DELETE FROM person WHERE id=$id");
                  $estado=$sentencia->execute();
                  $response["erro"] = false;            
                  $response["mensagem"] = "A pessoa foi excluída corretamente !"; 
                }else{
                  $response["erro"] = true;            
                  $response["codigo_erro"] = 888;            
                  $response["mensagem"] = "A pessoa não está no banco de dados"; 
                } 
              } else{
                $response["erro"] = true;            
                $response["codigo_erro"] = 999;            
                $response["mensagem"] = "Você deve incluir o ID da pessoa !";                
            }              
         }
        catch (Exception  $e) {     
            $response["erro"] = true;
            $response["codigo_erro"] = $e->getCode();
            $response["mensagem"] = $e->getMessage();             
        }
        return $response;
    }  
    public function actualizarPersona($param){ 
      // FUNÇÃO PARA O PUT. PARA ACTUALIZAR UM REGISTRO NA TABELA "PESSOAS"
      try{

          if($param['id'] != null && $param['id'] != "") {
                $sql = "SELECT * FROM person where id=".$param['id'];
                $resultado = $this->conn->query($sql);

                if($resultado->rowCount()>0){
                    $sentencia = $this->conn->prepare("update person set 
                                              name=:name, 
                                              surname=:surname,
                                              email=:email,
                                              address=:address, 
                                              phone=:phone,
                                              website=:website
                                              where id=:id");
                    
                    $estado=$sentencia->execute(
                            array(
                                ':id'=>$param['id'],
                                ':name'=> $param['nombre'],
                                ':surname'=> $param['apellido'],
                                ':email'=> $param['email'],
                                ':address'=> $param['direccion'],
                                ':phone'=> $param['telefono'],
                                ':website'=> $param['website']
                                )
                            );
                  
                  $response["erro"] = false;            
                  $response["mensagem"] = "A pessoa foi actualizada corretamente !"; 
                }else{
                  $response["erro"] = true;            
                  $response["codigo_erro"] = 888;            
                  $response["mensagem"] = "A pessoa não está no banco de dados"; 
                } 
              } else{
                $response["erro"] = true;            
                $response["codigo_erro"] = 999;            
                $response["mensagem"] = "Você deve incluir o ID da pessoa ! !";                
            }  
        }
        catch (Exception  $e) {     
            $response["erro"] = true;
            $response["codigo_erro"] = $e->getCode();
            $response["mensagem"] = $e->getMessage();             
        }
        return $response;
    } 

/*###############################################################*/    
/*################ FUNÇÕES RELATIVAS À CONTATOS##################*/
/*###############################################################*/
     public function consultarContacto($id){
      // FUNÇÃO PARA O GET. CONSULTA A TABELA "CONTATO" POR ID
      // SE LHE PASSA A PALAVRA "ALL" RETORNA TODOS OS REGITROS      
        $sql = "SELECT * FROM contact where id=".($id != 'all'?$id:'id');

        $resultado = $this->conn->query($sql);
       
        $contactos=Array();
        $i=0;
        if($resultado->rowCount()>0){
            foreach ($resultado as $fila) {                
                       $contactos[$i]=array('id'=>$fila['id'],
                                           'id_persona'=>$fila['id_person'], 
                                           'tipo'=>$fila['type'], 
                                           'valor'=>$fila['value'],
                                           );
                       $i++;
                     }

        } 
        return $contactos;
    }  
    public function insertarContacto($param){
      // FUNÇÃO PARA O POST.CRIE UM NOVO REGISTO NA TABELA "CONTATO"
        try{

              $sql = "SELECT * FROM person where id=".$param['id_persona'];
              $resultado = $this->conn->query($sql);
              if($resultado->rowCount()>0){

                $sentencia = $this->conn->prepare("INSERT INTO contact (id_person,type,value) VALUES (?,?,?)");
                $sentencia->execute(array($param['id_persona'],
                                          $param['tipo'], 
                                          $param['valor']));
                $response["erro"] = false;            
                $response["mensagem"] = "O contato foi adicionado corretamente !";  
            }else{
                $response["erro"] = true;            
                $response["codigo_erro"] = 555;            
                $response["mensagem"] = "o ID da pessoa não está no banco de dados!";                
            }
             
        }
        catch (Exception  $e) {     
            $response["erro"] = true;
            $response["codigo_erro"] = $e->getCode();
            $response["mensagem"] = $e->getMessage();             
        }
        return $response;
    }
    public function eliminarContacto($id){    
      // FUNÇÃO PARA O DELETE. REMOVE UM REGISTO NA TABELA "CONTATO"
        try{

          if($id != null && $id != "") {
                $sql = "SELECT * FROM contact where id=$id";
                $resultado = $this->conn->query($sql);

                if($resultado->rowCount()>0){
                  $sentencia = $this->conn->prepare("DELETE FROM contact WHERE id=$id");
                  $estado=$sentencia->execute();
                  $response["erro"] = false;            
                  $response["mensagem"] = "O contato foi excluída corretamente !"; 
                }else{
                  $response["erro"] = true;            
                  $response["codigo_erro"] = 888;            
                  $response["mensagem"] = "O contato não está no banco de dados"; 
                } 
              } else{
                $response["erro"] = true;            
                $response["codigo_erro"] = 999;            
                $response["mensagem"] = "Você deve incluir o ID do contato !";                
            }              
         }
        catch (Exception  $e) {     
            $response["erro"] = true;
            $response["codigo_erro"] = $e->getCode();
            $response["mensagem"] = $e->getMessage();             
        }
        return $response;
    }           
    public function actualizarContacto($param){ 
      // FUNÇÃO PARA O PUT. PARA ACTUALIZAR UM REGISTRO NA TABELA "CONTATO"
      try{

          if($param['id'] != null && $param['id'] != "") {
                $sql = "SELECT * FROM contact where id=".$param['id'];
                $resultado = $this->conn->query($sql);

                if($resultado->rowCount()>0){
                    $sentencia = $this->conn->prepare("update contact set 
                                              id_person=:id_person, 
                                              type=:type,
                                              value=:value
                                              where id=:id");
                    
                    $estado=$sentencia->execute(
                            array(
                                ':id'=>$param['id'],
                                ':id_person'=> $param['id_persona'],
                                ':type'=> $param['tipo'],
                                ':value'=> $param['valor']
                                )
                            );
                  
                  $response["erro"] = false;            
                  $response["mensagem"] = "O contato foi actualizado corretamente !"; 
                }else{
                  $response["erro"] = true;            
                  $response["codigo_erro"] = 888;            
                  $response["mensagem"] = "O contato não está no banco de dados"; 
                } 
              } else{
                $response["erro"] = true;            
                $response["codigo_erro"] = 999;            
                $response["mensagem"] = "Você deve incluir o ID do contato ! !";                
            }  
        }
        catch (Exception  $e) {     
            $response["erro"] = true;
            $response["codigo_erro"] = $e->getCode();
            $response["mensagem"] = $e->getMessage();             
        }
        return $response;
    } 
 }
?>