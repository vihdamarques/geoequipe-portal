<?php   
    include_once 'class/Usuario.php';
    session_start();
    class Autenticacao{
        private $_conn;
        //construtor
        public function __construct($conn){
            $this->_conn = $conn;                       
        }

        public function consultarLogin($usuario, $senha){
            $stmt = $this->_conn->prepare("SELECT * FROM ge_usuario WHERE usuario = :usuario AND senha = :senha");
            $stmt->bindValue(":usuario", $usuario);
            $stmt->bindValue(":senha", $senha);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            return $resultado;
        }

        public function consultarId($id){
            $stmt = $this->_conn->prepare("SELECT * FROM ge_usuario WHERE id_usuario = :id");
            $stmt->bindValue(":id", $id);       
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            return $resultado;
        }

        public function login ($usuario, $senha){
            $valida = $this->consultarLogin($usuario, $senha);
            if (count($valida) == 1){
                foreach ($valida as $value) {
                    $usuario = new Usuario($value["id_usuario"]
                                          ,$value["usuario"]
                                          ,$value["senha"]
                                          ,$value["nome"]
                                          ,$value["email"]
                                          ,$value["celular"]
                                          ,$value["telefone"]
                                          ,$value["ativo"]
                                          ,$value["id_ultimo_sinal"]
                                          ,$value["perfil"]);
                    
                    $string = serialize($usuario); //serializa objeto em uma string
                    //session_start();
                    $_SESSION["usuario"] = $string; //salva a string na sessão
                    return true;
                }
            } else {
                return false;
                }
            }

        public function autenticar(){
            try {
                //if(!isset($_SESSION)){
                    //session_start();
                //}

                $string = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "";
                if ($string == null) {
                    header("Location: login.php");
                } else {
                    $usuario = unserialize($string);
                    $valida = $this->consultarId($usuario->getId());
                    if (count($valida) == 0) header("Location: login.php"); 
                }
            }
            catch(Exception $e) {
                echo ($e->getMessage());
            }
        }

        public function autenticarCadUsua() {
            //session_start();
            $string = isset($_SESSION["usuario"]) ? $_SESSION["usuario"]: "" ;
            $usuario = new Usuario();
            $usuario = unserialize($string);
            $perfil = $usuario->getPerfil();
            return $perfil;
        }

        public function autenticarCadTarefa(){
            //session_start();
            $string = isset($_SESSION["usuario"]) ? $_SESSION["usuario"]: "" ;
            $usuario = new Usuario();
            $usuario = unserialize($string);
            $id = $usuario->getId();
            return $id;
        }

        public function hashSenha($string){
            $hash = sha1("wnhg9".$string."fwj98");
            return $hash;
        }

        public function encripta($string){
            $codigo = base64_encode($string);
            return $codigo;
        }

        public function decripta($string){          
            $codigo = base64_decode($string);           
            return $codigo;
        }

        public function logout(){
            session_start();
            session_unset(); //libera as variáveis da sessão
            session_destroy(); //destroí a sessão
        }

    }       
?>