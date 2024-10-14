<?php
    namespace App\Database;
    use PDO;
    class DB{
        private static $host = 'localhost';
        private static $user = 'root';
        private static $password = '';
        private static $database = 'library_db';
        
        public static function connect(){
            try{
                $conn = new PDO("mysql:host=".self::$host.";dbname=".self::$database, self::$user, self::$password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            }catch(PDOException $e){
                echo "Error while connecting to the database: " . $e->getMessage();
                echo "Connection failed: " . $e->getMessage();
            }
        }

    }
?>