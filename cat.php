<?php

class Cat
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //增加
    public function add($rows)
    {
        $title = $rows['title'];
        $parent_id = $rows['parent_id'];
        $sql = "insert into cat (title,parent_id) values( '{$title}', '{$parent_id}')";
        $row = $this->pdo->prepare($sql);
        $row->execute();
        return $this->read();
    }

    //删除
    public function remove($rows)
    {
        $id = $rows['id'];
        $sql = "delete from cat where id = ?";
        $row = $this->pdo->prepare($sql);
        $row->bindValue(1, $id);
        $row->execute();
        return $this->read();
    }

    //更新
    public function update($rows)
    {
        $id = $rows['id'];
        $sql = "select * from cat where id = ?";
        $aa = $this->pdo->prepare($sql);
        $aa->bindValue(1, $id);
        $aa->execute();
        $data = $aa->fetch(PDO::FETCH_ASSOC);
        $cc = array_merge($data, $rows);
        $spl = "update cat set title = :title,parent_id = :parent_id where id = :id";
        $ee = $this->pdo->prepare($spl);
        $ee->execute($cc);
        return $this->read();
    }

    //查找
    public function read()
    {
        $page=$_GET['page'] ?: 1;
        $limit=5;
        $offset=$limit * ($page-1);
        $spl = "select * from cat limit :offset, :limit";
        $row = $this->pdo->prepare($spl);
        $row->execute([
            'offset' => $offset,
            'limit'  => $limit,
        ]);
        $a = $row->fetchAll(PDO::FETCH_ASSOC);
        return $a;
    }
}