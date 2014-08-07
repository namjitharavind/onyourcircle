<?php

namespace User\Entity;

class User {

    public $id;
    public $email;
    public $password;
    public $user_type_id;
    public $created_at;
    public $updated_at;
    public $first_name;
    public $last_name;
    public $address1; 
    public $address2;
    public $phone1;
    public $phone2;
    public $country;
    public $state;
    public $pincode;
    public $register_token;
    



    public function setPassword($clear_password) {

        $this->password = md5($clear_password);
    }

    public function setToken($clear_token) {

        $this->register_token = md5($clear_token);
    }

    function exchangeArray($data) {

        $this->id = isset($data['id']) ? $data['id'] : " ";
        $this->email = isset($data['email']) ? $data['email'] : " ";
        $this->user_type_id = isset($data['user_type_id']) ? $data['user_type_id'] : " ";
        $this->created_at = isset($data['created_at']) ? $data['created_at'] : " ";
        $this->updated_at = isset($data['updated_at']) ? $data['updated_at'] : " ";
        $this->first_name = isset($data['first_name']) ? $data['first_name'] : " ";
        $this->last_name = isset($data['last_name']) ? $data['last_name'] : " ";
        $this->address1 = isset($data['address1']) ? $data['address1'] : " ";
        $this->address2 = isset($data['address2']) ? $data['address2'] : " ";
        $this->phone1 = isset($data['phone1']) ? $data['phone1'] : " ";
        $this->phone2 = isset($data['phone2']) ? $data['phone2'] : " ";
        $this->country = isset($data['country']) ? $data['country'] : " ";
        $this->state = isset($data['state']) ? $data['state'] : " ";
        $this->pincode = isset($data['pincode']) ? $data['pincode'] : " ";
        $this->register_token = isset($data['register_token']) ? $data['register_token'] : " ";
        
        if (isset($data["user_password"])) {
            $this->setPassword($data["user_password"]);
        }
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
?>

