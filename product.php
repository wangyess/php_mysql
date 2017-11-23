<?php

class Product
{
    public $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    //增加
    public function add($rows)
    {
        $title = @$rows['title'];
        $price = @$rows['price'];
        $cover_url = @$rows['cover_url'];
        $stock = @$rows['stock'];
        $des = @$rows['des'];
        $cat_id = @$rows['cat_id'];
        if (!$title || !$price || !$cat_id) {
            return ['success=>false'];
        }
        $sql = "insert into product (title, price, cat_id) values('{$title}', '{$price}', '{$cat_id}')";
        $str = $this->pdo->prepare($sql);
        $str->execute();
        return $this->read();
    }

    //删除
    public function remove($rows)
    {
        $id = $rows['id'];
        $sql = "delete from product where id = ?";
        $row = $this->pdo->prepare($sql);
        $row->bindValue(1, $id);
        $row->execute();

//        $id=$rows['id'];
//        $sql="delete from user where id = :id";
//        $row=$this->pdo->prepare($sql);
//        $row->execute(['id' => $id]);
////      $row->execute();
        return $this->read();
    }

    //修改
    public function update($rows)
    {
        $id = $rows['id'];
        $sql = " select * from product where id = ? ";
        $a = $this->pdo->prepare($sql);
        $a->bindValue(1,$id);
        $a->execute();
        $old = $a->fetch(PDO::FETCH_ASSOC);
        $merge = array_merge($old, $rows);
        $sql_1 = "update product set title= :title ,price= :price, cat_id= :cat_id ,cover_url= :cover_url, stock= :stock ,des= :des where id = :id";
        $c = $this->pdo->prepare($sql_1);
        $c->execute($merge);
        return $this->read();
    }

    //查看
    public function read()
    {
        $page = (int)@$_GET['page'] ?: 1;
        $limit = 5;
        $offset = $limit * ($page - 1);

        $sqql = "select * from product limit :offset, :limit";
        $a = $this->pdo->prepare($sqql);
        $a->execute(
            [
                'offset' => $offset,
                'limit' => $limit,
            ]
        );
        $aad = $a->fetchAll(PDO::FETCH_ASSOC);
        return $aad;
    }
}

