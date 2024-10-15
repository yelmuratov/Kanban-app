<?php
namespace App\Models;
use App\Database\DB;
use PDO;

class Model extends DB {
    public static function getAll() {
        try {
            $db = self::connect();
            $sql = "SELECT * FROM " . static::$table;
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function create($data) {
        try {
            $db = self::connect();
            $sql = "INSERT INTO " . static::$table . " (";
            $columns = implode(",", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql .= $columns . ") VALUES (" . $values . ")";
            $query = $db->prepare($sql);
            return $query->execute($data);
        } catch (\PDOException $e) {
            if ($e->getCode() == '23000') {
                return false;
            } else {
                throw $e;
            }
        }
    }

    public static function delete($id) {
        try {
            $db = self::connect();
            $query = $db->prepare("DELETE FROM " . static::$table . " WHERE id = :id");
            return $query->execute(['id' => $id]);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function update($id, $data) {
        try {
            $db = self::connect();
            $sql = "UPDATE " . static::$table . " SET ";
            foreach ($data as $key => $value) {
                $sql .= $key . " = :" . $key . ",";
            }
            $sql = rtrim($sql, ",");
            $sql .= " WHERE id = :id";
            $data['id'] = $id;
            $query = $db->prepare($sql);
            return $query->execute($data);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function find($id) {
        try {
            $db = self::connect();
            $query = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function count() {
        try {
            $db = self::connect();
            $sql = "SELECT COUNT(*) FROM " . static::$table;
            $query = $db->query($sql);
            return $query->fetchColumn();
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function paginate($page, $limit) {
        try {
            $db = self::connect();
            $offset = ($page - 1) * $limit;
            $sql = "SELECT * FROM " . static::$table . " LIMIT :limit OFFSET :offset";
            $query = $db->prepare($sql);
            $query->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $query->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function where($column, $value) {
        try {
            $db = self::connect();
            $query = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . $column . " = :value");
            $query->execute(['value' => $value]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }

    public static function query($sql) {
        try {
            $db = self::connect();
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Handle exception as needed
            return false;
        }
    }
}
?>
