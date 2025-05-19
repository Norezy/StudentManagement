<?php

require_once 'Model.php';

class Subject_Enrollment extends Model{
    protected static $table = 'subject_enrollments';

    public $id;
    public $student_id;
    public $subject_id;
    public $status;

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
            'student_id' => $this->student_id,
            'subject_id' => $this->subject_id,
            'status' => $this->status,
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

    public static function findBywhere($column, $operator, $value){
        $result = parent::where($column, $operator, $value);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }

    public static function findByStudentID($value){
        $result = parent::where('student_id', '=', $value);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }

    public static function findSubject_EnrollmentByStudIDandSubID($Value, $Value2){
        $result = parent::whereAnd('student_id','=', $Value,'subject_id','=', $Value2);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }
    
}