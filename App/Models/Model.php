<?php
    namespace App\Models;
    use App\Database\DB;
    use PDO;

    class Model extends DB{
        public static function getAll(){
            $db = self::connect();
            $sql = "SELECT * FROM " . static::$table;
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function create($data){
            $db = self::connect();
            $sql = "INSERT INTO " . static::$table . " (";
            $columns = implode(",", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql .= $columns . ") VALUES (" . $values . ")";
            $query = $db->prepare($sql);
            return $query->execute($data);
        }

        public static function delete($id){
            $db = self::connect();
            $query = $db->prepare("DELETE FROM " . static::$table . " WHERE id = :id");
            return $query->execute(['id' => $id]);
        }

        public static function update($id, $data){
            $db = self::connect();
            $sql = "UPDATE " . static::$table . " SET ";
            foreach($data as $key => $value){
                $sql .= $key . " = :" . $key . ",";
            }
            $sql = rtrim($sql, ",");
            $sql .= " WHERE id = :id";
            $data['id'] = $id;
            $query = $db->prepare($sql);
            return $query->execute($data);
        }

        public static function find($id){
            $db = self::connect();
            $query = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public static function count(){
            $db = self::connect();
            $sql = "SELECT COUNT(*) FROM " . static::$table;
            $query = $db->query($sql);
            return $query->fetchColumn();
        }

        public static function paginate($page, $limit){
            $db = self::connect();
            $sql = "SELECT * FROM " . static::$table . " LIMIT " . $limit . " OFFSET " . ($page - 1) * $limit;
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function where($column, $value){
            $db = self::connect();
            $query = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . $column . " = :value");
            $query->execute(['value' => $value]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function query($sql){
            $db = self::connect();
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>