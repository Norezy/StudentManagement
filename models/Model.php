<?php

class Model{
    protected static $conn;
    protected static $table;

    public static function setConnection($conn){
        self::$conn = $conn;
    }

    protected static function all(){
        try{
            $sql = "SELECT * FROM " . static::$table;

            $result = self::$conn->query($sql);

            $rows = $result->fetchAll();

            return count($rows) > 0
                ? $rows : null; 
        }
        catch(PDOException $e){
            die("Error fetching data: " . $e->getMessage());
        }
    }

    protected static function find($id){
        try{
            $sql = "SELECT * FROM " . static::$table
                . " WHERE id = :id";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindParam(':id', $id);

            $stmt->execute();

            $row = $stmt->fetch();

            return $row ?? null;
        }
        catch(PDOException $e){
            die("Error fetching data: " . $e->getMessage());
        }
    }

    protected static function create(array $data){
        try{
            $columns = implode(", ", array_keys($data));
            $values = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));

            $sql = "INSERT INTO " . static::$table
                . " ($columns) VALUES ($values)";

            $stmt = self::$conn->prepare($sql);

            foreach($data as $key => $value){
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();

            $id = self::$conn->lastInsertId();

            return self::find($id);
        }
        catch(PDOException $e){
            die("Error creating data: " . $e->getMessage());
        }
    }

    protected static function updateById($id, array $data){
        try{
            $set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));   
        
            $sql = "UPDATE " . static::$table
                . " SET $set WHERE id = :id";

            $stmt = self::$conn->prepare($sql);

            foreach($data as $key => $value){
                $stmt->bindValue(":$key", $value);
            }

            $stmt->bindValue(':id', $id);

            $stmt->execute();

            return self::find($id);
        }
        catch(PDOException $e){
            die("Error updating data: " . $e->getMessage());
        }
    }

    protected static function deleteById($id){
        try{
            $sql = "DELETE FROM " . static::$table
                . " WHERE id = :id";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id);

            return $stmt->execute();
        }
        catch(PDOException $e){
            die("Error deleting data: " . $e->getMessage());
        }
    }

    protected static function where($column, $operator, $value){
        try{
            $sql = "SELECT * FROM " . static::$table
                . " WHERE $column $operator :value";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':value', $value);

            $stmt->execute();

            $rows = $stmt->fetchAll();

            return count($rows) > 0
                ? $rows : null;
        }
        catch(PDOException $e){
            die("Error fetching data: " . $e->getMessage());
            
        }
    }

    protected static function whereAnd($column, $operator, $value, $column2, $operator2, $value2){
        try{
            $sql = "SELECT * FROM " . static::$table
                . " WHERE $column $operator :value AND $column2 $operator2 :value2";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':value', $value);
            $stmt->bindValue(':value2', $value2);
            
            $stmt->execute();

            $rows = $stmt->fetchAll();

            return count($rows) > 0
                ? $rows : null;
        }
        catch(PDOException $e){
            die("Error fetching data: " . $e->getMessage());
            
        }
    }

    protected function belongsToMany($relatedClass, $pivotTable, $foreignKey, $relatedKey){
        try{
            $relatedTable = $relatedClass::$table;

            $sql = "SELECT rt.* FROM $relatedTable rt INNER JOIN $pivotTable pt ON rt.id = pt.$relatedKey WHERE pt.$foreignKey = :id";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $this->id);

            $stmt->execute();

            $rows = $stmt->fetchAll();

            return $rows
            ? array_map(fn($data) => new $relatedClass($data), $rows)
            : [];
        }
        catch(PDOException $e){
            die("Error fetching data: " . $e->getMessage());
        }
    }

}