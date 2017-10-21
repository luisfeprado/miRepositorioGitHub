<?php
/**
 *
 * @About:      Clase de conexão ao banco de dados     
 * @Date:       $Date:$ Oct-2017
 * @Version:    $Rev:$ 1
 * @Developer:  Luis Prado
 **/
class DbConnect {
 
    private $conn;
 
    function __construct() {        
    } 
    /**
     * Estabelecimento de conexão de banco de dados
     * @return manipulador de conexão de banco de dados
     */
    function connect() {
        include_once dirname(__FILE__) . './Config.php';

        try {
     
            $this->conn = new PDO('mysql:host=' .DB_HOST.
                                        ';dbname='.DB_NAME.';charset=utf8', 
                                        DB_USERNAME,DB_PASSWORD
                                        );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // retornando recurso de conexão
            return $this->conn;

        } catch(PDOException $ex) {
            
            if ( (defined('ENVIRONMENT')) && (ENVIRONMENT == 'development') ) {
                echo 'Ocorreu um erro ao se conectar ao banco de dados! Detalhes: ' . $ex->getMessage();
            } else {
                echo 'Ocorreu um erro ao se conectar ao banco de dados!';
            }
            exit;
        }
        
    }
 
}
?>