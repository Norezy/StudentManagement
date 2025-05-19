<?php

require_once 'Model.php';
require_once 'Subject.php';

class User extends Model{
    protected static $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $status;
    public $avatar;
    public $created_at;
    public $updated_at;

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
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'status' => $this->status,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
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



    public function subjects(){
        $result = Subject::where('instructor_id', '=', $this->id);

        return $result ?? null;
    }

    

}