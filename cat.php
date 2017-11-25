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
        //判断是否传title
        if (!$title) {
            return ['success' => false, 'msg' => 'invalid:title'];
        }
        //判断是否存在
        if ($this->title_exist($title)) {
            return ['success' => false, 'msg' => 'exist:title'];
        }

        $parent_id = $rows['parent_id'] ? (int)$rows['parent_id'] : null;

        //判断是否传parent_id
//        if (!$parent_id && !is_numeric($parent_id)) {
//            return ['success' => false, 'msg' => 'invalid:parent_id'];
//        }

        $sql = "insert into cat (title,parent_id) values( '{$title}', '{$parent_id}')";
        $row = $this->pdo->prepare($sql);
        $r = $row->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    //删除
    public function remove($rows)
    {
        $id = $rows['id'];
        if (!$id) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        $sql = "delete from cat where id = ?";
        $row = $this->pdo->prepare($sql);
        $row->bindValue(1, $id);
        $r = $row->execute();
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    //更新
    public function update($rows)
    {
        $id = $rows['id'];
        $title = $rows['title'];
        //判断是否传入了ID
        if (!$id) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        $data = $this->find_id($id);
        //判断数据库中是否已经存在这个ID
        if (!$data) {
            return ['success' => false, 'msg' => 'invalid:id'];
        }
        //判断title是否重复
        if ($this->title_exist($title, $id)) {
            return ['success' => false, 'msg' => 'exist:title'];
        }
        $cc = array_merge($data, $rows);
        $spl = "update cat set title = :title,parent_id = :parent_id where id = :id";
        $ee = $this->pdo->prepare($spl);
        $r = $ee->execute($cc);
        return $r ? ['success' => true] : ['success' => false, 'msg' => 'internal_error'];
    }

    //查找
    public function read($rows)
    {
        $id = $rows['id'];
        $page = $_GET['page'] ?: 1;
        $limit = 10;
        $offset = $limit * ($page - 1);

        if ($id) {
            $s = $this->pdo->prepare('select * from cat where id = :id');
            $s->execute(['id' => $id]);
            $d = $s->fetch(PDO::FETCH_ASSOC);
        } else {
            $spl = "select * from cat order by id desc limit :offset, :limit";
            $row = $this->pdo->prepare($spl);
            $row->execute([
                'offset' => $offset,
                'limit' => $limit,
            ]);
            $d = $row->fetchAll(PDO::FETCH_ASSOC);
        }
        return ['success' => true, 'data' => $d];
    }

    //判断数据库中是否已经存在这个名字的title
    public function title_exist($title, $id = null)
    {
        $sql = "select * from cat where title = :title";
        $hole = ['title' => $title];

        if ($id) {
            $sql = $sql . ' and id <> :id';
            $hole['id'] = $id;
        }

        $sta = $this->pdo->prepare($sql);
        $sta->execute($hole);
        $str = $sta->fetch(PDO::FETCH_ASSOC);
        return (bool)$str;
    }

    //判断数据库中是否已经有这个ID
    public function find_id($id)
    {
        $sql = "select * from cat where id = :id";
        $sta = $this->pdo->prepare($sql);
        $sta->execute(['id' => $id]);
        $r = $sta->fetch(PDO::FETCH_ASSOC);
        return $r;
    }
}