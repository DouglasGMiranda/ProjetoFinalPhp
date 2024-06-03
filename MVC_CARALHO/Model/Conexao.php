<?php 

    class Conexao {

        public static function conectar() {

            try{
                $conn = new PDO("mysql:host=localhost;Port=3306;dbname=logistica", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }
            catch(PDOException $erro) {
                echo "Conexão falhou! " . $erro->getMessage();
                return null;
            }
        }   
    }

?>