<?php

class User
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //增加
    public function add($rows)
    {
        $username = @$rows['username'];
        $password = @$rows['password'];
        $permission = @$rows['permission'];
        if (!$username || !$password) {
            return ['success' => false, 'msg' => 'invaild:username||password'];
        }
        $sql = "insert into user (username, password, permission) values('{$username}', '{$password}', '{$permission}')";
        $row = $this->pdo->prepare($sql);
        $r = $row->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    //删除
    public function remove($rows)
    {
        $id = $rows['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'invaild:id'];
        }
        $sql = "delete from user where id = ?";
        $row = $this->pdo->prepare($sql);
        $row->bindValue(1, $id);
        $r = $row->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    //更新
    public function update($rows)
    {
        $id = $rows['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'invaild:id'];
        }
        $data = $this->find_item($id);
        if (!$data) {
            return ['success' => false, 'msg' => 'invaild:find_item'];
        }
        $cc = array_merge($data, $rows);
        $spl = "update user set username= :username ,password= :password, permission= :permission, data= :data  where id = :id";
        $ee = $this->pdo->prepare($spl);
        $r = $ee->execute($cc);
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    //查找
    public function read()
    {
        $page = (int)@$_GET['page'] ?: 1;
        $limit = 5;
        $offset = $limit * ($page - 1);
        $sqql = "select * from user limit :offset, :limit";
        $a = $this->pdo->prepare($sqql);
        $a->execute([
            'offset' => $offset,
            'limit' => $limit,
        ]);
        $aad = $a->fetchAll(PDO::FETCH_ASSOC);
        return $aad;
    }

    //判断数据库是否有这条
    public function find_item($id)
    {
        $sql = "select * from user where id = :id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute([
            'id' => $id,
        ]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}