<?php

require_once 'Model.php';
require_once 'Course.php';
require_once "Subject.php";


class Student extends Model{
    protected static $table = 'students';

    public $id;
    public $student_id;
    public $name;
    public $gender;
    public $birthdate;
    public $course_id;
    public $year_level;
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
            'name' => $this->name,
            'gender' => $this -> gender,
            'birthdate' => $this->birthdate,
            'course_id' => $this->course_id,
            'year_level' => $this->year_level,
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

    public static function findByEmail($value){
        $result = parent::where('email', '=', $value);

        if($result){
            return new self(array_shift($result));
        }
        else{
            return null;
        }
    }

    public static function findByRole($value){
        $result = parent::where('role', '=', $value);

        return $result
            ? array_map(fn($data) => new self($data), $result)
            : null;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+!@#$%^&*';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }

    // one to one
    public function course(){
        return Course::find($this->course_id);
    }

    public function subject_enrollment(){
        $result = Subject_Enrollment::findBywhere('student_id', '=', $this->id);

        return $result ?? null;
    }

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'subject_enrollments', 'student_id', 'subject_id');
    }

    public function grades(){
        $result = Grade::where('student_id', '=', $this->id);

        return $result ?? null;
    }
}