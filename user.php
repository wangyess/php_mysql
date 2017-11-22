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
        $sql = "insert into user (username, password, permission) values('{$username}', '{$password}', '{$permission}')";
        $row = $this->pdo->prepare($sql);
        $row->execute();
        return $this->read();
    }

    //删除
    public function remove($rows)
    {
        $id = $rows['id'];
        $sql = "delete from user where id = ?";
        $row = $this->pdo->prepare($sql);
        $row->bindValue(1, $id);
        $row->execute();
        return $this->read();
    }

    //更新
    public function update($rows)
    {
        $id = $rows['id'];
        $sql = "select * from user where id = ?";
        $aa = $this->pdo->prepare($sql);
        $aa->bindValue(1, $id);
        $aa->execute();
        $data = $aa->fetch(PDO::FETCH_ASSOC);
        $cc = array_merge($data, $rows);
        $spl = "update user set username= :username ,password= :password, permission= :permission, data= :data  where id = :id";
        $ee = $this->pdo->prepare($spl);
        $ee->execute($cc);
        return $this->read();
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
}