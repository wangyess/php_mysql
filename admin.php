<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>这个天才又来啦❤️</title>
    <style>
        .one {
            height: 740px;
            background-color: #e8efef;
        }
        label{
            margin-left: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
<div class="page-header">
    <h1>Product</h1>
</div>
<div class="row">
    <div class="col-md-3 one">
        <form class="form-horizontal" id="my-form">
            <div class="form-group">
                <label class="col-sm-10 control-label">
                     <input type="hidden" name="id" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    title: <input type="text" name="title" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    price: <input type="text" name="price" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    cat_id:
                    <select name="cat_id" class="form-control"></select>
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    cover_url:
                    <input type="text" name="cover_url" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    stock:
                    <input type="text" name="stock" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    des:
                    <input type="text" name="des" class="form-control">
                </label>
            </div>
            <div class="form-group">
                <label class="col-sm-10 control-label">
                    <button type="submit" class="btn btn-default col-sm-12">提交</button>
                </label>
            </div>
        </form>
    </div>
    <div class="col-md-9">
        <div class="page-header">
            <h2>Show</h2>
        </div>
        <div class="show-page">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Cat_id</th>
                    <th>Operation</th>
                </tr>
                <tbody  id="first-tbody">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
<script src="product_base.js"></script>
</body>
</html>