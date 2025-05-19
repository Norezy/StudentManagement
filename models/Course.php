<?php

require_once 'Model.php';
require_once 'Student.php';


class Course extends Model{
    protected static $table = 'courses';

    public $id;
    public $code;
    public $name;

    public function __construct(array $data = []){
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }

    public static function all(){
        $result = parent::all();

        return $result
            ? array_map(fn($data) => new self($data), $result)
            : null;
    }

    public static function find($id){
        $result = parent::find($id);

        return $result
            ? new self($result)
            : null;
    }

    public static function create(array $data){
        $result = parent::create($data);

        return $result
            ? new self($result)
            : null;
    }

    public function update(array $data){
        $result = parent::updateById($this->id, $data);

        if($result){
            foreach($data as $key => $value){
                if(property_exists($this, $key)){
                    $this->$key = $value;
                }
            }
            return true;
        }
        else{
            return false;
        }
    }

    public function save(){
        $data = [
            'name' => $this->name,
            'code' => $this->code,
        ];

        return $this->update($data);
    }

    public function delete(){
        $result = parent::deleteById($this->id);

        if($result){
            foreach($this as $key => $value){
                unset($this->$key);
            }
            return true;
        }
        else{
            return false;
        }
    }

    public static function where($column, $operator, $value){
        $result = parent::where($column, $operator, $value);

        return $result
            ? array_map(fn($data) => new self($data), $result)
            : null;
    }

    public static function findByEmail($value){
        $result = parent::where('email', '=', $value);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }

    public static function findByCode($value){
        $result = parent::where('code', '=', $value);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }

    public function students(){
        $result = Student::where('course_id', '=', $this->id);

        return $result ?? null;
    }
}