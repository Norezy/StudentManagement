<?php

require_once 'Model.php';

class Grade extends Model{
    protected static $table = 'Grades';

    public $id;
    public $instructor_id;
    public $grade;
    public $remarks;


    public function __construct(array $data = []){
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
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
            'instructor_id' => $this->instructor_id,
            'grade' => $this->grade,
            'remarks' => $this->remarks
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

    public static function FindByStudentid( $value){
        $result = parent::where('student_id','=', $value);

    if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
    }
    }
    

    public static function FindByStudidAndSubid($Value, $Value2){
        $result = parent::whereAnd('student_id','=', $Value,'subject_id','=', $Value2);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }
    
    public static function getGrades($Value, $Value2){
        $result = parent::whereAnd('student_id','=', $Value,'subject_id','=', $Value2);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }

    
}