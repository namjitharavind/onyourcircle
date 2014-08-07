<?php

namespace User\Dao;

use Zend\Db\TableGateway\TableGateway;

class UserDAO {

    protected $tableGateway;
    protected $dbAdapter;

    public function __construct(TableGateway $tableGateway,$dbAdapter) {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    
    
    

    public function saveUser(User $user) {



        $user_id = (int) $user->user_id;
        if ($user_id == 0) {
            $data = array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_email' => $user->user_email,
                'user_password' => $user->user_password,
                'user_status' => $user->user_status,
                'user_type' => $user->user_type,
                'country_id' => $user->country_id,
                'sp_id' => $user->sp_id,
                'register_date' => $user->register_date,
                'register_token' => $user->register_token,
                'email_confirmed' => $user->email_confirmed,
            );
        }

        if ($user_id != 0) {
            $data = array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'country_id' => $user->country_id,
                'phone1' => $user->phone1,
                'phone2' => $user->phone2,
                'address1' => $user->address1,
                'address2' => $user->address2,
                'city' => $user->city,
                'zipcode' => $user->zipcode,
                'about_me' => $user->about_me,
                'gender' => $user->gender,
                'dob' => $user->dob,
                'height_ft' => $user->height_ft,
                'height_in' => $user->height_in,
                'stride_length_ft' => $user->stride_length_ft,
                'stride_length_in' => $user->stride_length_in,
                'running_stride_length_ft' => $user->running_stride_length_ft,
                'running_stride_length_in' => $user->running_stride_length_in,
                'body_weight_m_id' => $user->body_weight_m_id
            );
        }


        if ($user_id == 0) {
            $this->tableGateway->insert($data);
            $user_id = $this->tableGateway->getLastInsertValue();
        } else {
            if ($this->getUser($user_id)) {
                $this->tableGateway->update($data, array('user_id' => $user_id));
            } else {
                throw new \Exception('User ID does not exist');
            }
        }

        return $user_id;
    }

    public function saveUserImage($user_id, $file_name) {


        if ($this->getUser($user_id)) {
            $this->tableGateway->update(array(
                'image' => $file_name,
                    ), array('user_id' => $user_id));
        } else {
            throw new \Exception('User ID does not exist');
        }


        return $user_id;
    }

    public function getUser($user_id) {

        $user_id = (int) $user_id;
        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $user_id");
        }
        return $row;
    }

   

    public function activateUser($user_id) {
        $data['user_status'] = 1;
        $data['email_confirmed'] = 1;
        $this->tableGateway->update($data, array('user_id' => (int) $user_id));
    }

    public function activeUser($user_id) {

        $this->tableGateway->update(array('user_status' => 1), array('user_id' => (int) $user_id));
    }

    public function inactiveUser($user_id) {

        $this->tableGateway->update(array('user_status' => 0), array('user_id' => (int) $user_id));
    }

    public function getUserByEmail($user_email) {
        $rowset = $this->tableGateway->select(array('user_email' => $user_email));

        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function checkNormalUserExist($user_email = "") {

        $where = array();
        if ($user_email != "") {
            $where = array_merge($where, array('ws_user_master.user_email' => $user_email, 'ws_user_master.user_type' => 3));
        }

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->where($where);
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        $row = $resultSet->current();

        if (!$row) {
            return true;
        }

        return false;
    }

    public function changePassword($user_id, $password) {
        $data['user_password'] = md5($password);
        $this->tableGateway->update($data, array('user_id' => (int) $user_id));
    }

    public function getUserDetails($user_id = "", $sp_id = "") {


        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('user_id',
            'user_email',
            'first_name',
            'last_name',
            'user_status',
            'user_type',
            'phone1',
            'phone2',
            'address1',
            'address2',
            'image',
            'dob',
            'country_id',
            'city',
            'zipcode',
            'about_me',
            'sp_id',
            'register_date',
            'register_token',
            'email_confirmed'
        ));
        $sqlSelect->join(array('c' => 'countries')
                , 'c.country_id = ws_user_master.country_id', array('short_name'), 'left');

        $sqlSelect->where(array('sp_id' => $sp_id));
        //echo $sqlSelect->getSqlString(); exit;

        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function deleteUser($user_id) {
         $this->tableGateway->delete(array('user_id' => $user_id));
      
    }

}

?>