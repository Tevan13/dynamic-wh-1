<?php

namespace App\Models;

use CodeIgniter\Model;

class userModel extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'idUser';

    protected $allowedFields = ['username', 'password', 'hak_akses'];

    public function getUserList()
    {
        return $this->db->table('tb_user')->get()->getResultArray();
    }

    public function addUser($user)
    {
        return $this->db->table('tb_user')->insert($user);
    }

    public function updateUser($id, $user)
    {
        if ($this->db->table('tb_user')->getWhere(["idUser" => $id])->getResultArray() == null) {
            return $this->db->table('tb_user')->insert($user);
        }
        return $this->db->table('tb_user')->update($user, ["idUser" => $id]);
    }

    public function deleteUser($id)
    {
        return $this->db->query('DELETE FROM `tb_user` WHERE idUser=?', [$id]);
    }

    public function getUserByUnamePassword($uname, $pass)
    {
        $user = $this->db->table('tb_user')->where(['username' => $uname])->get()->getRowArray();

        if ($user) {
            if (password_verify($pass, $user['password'])) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
