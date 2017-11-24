;(function () {
    'use strict';
    //================================================定义商品数组
    var product_list = [];
    //================================================定义分类数组
    var cat_list = [];
    //选中页面中要用的
    //=============================================选中表单和table
    var my_form = document.getElementById('my-form');
    var first_tbody = document.getElementById('first-tbody');
    //..===============================================选中select
    var el_cat_option = document.querySelector('[name=cat_id]');

    //.............................................获取分类中的数据
    function get_cat_list() {
        $.get('./gateway.php?model=cat&action=read')
            .then(function (r) {
                cat_list = r.data;
                render_cat_list();
            })
    }

    //...................................................渲染分类
    function render_cat_list() {
        el_cat_option.innerHTML = "";
        for (var i = 0; i < cat_list.length; i++) {
            var item = cat_list[i];
            var option = document.createElement('option');
            option.innerHTML = item.title;
            option.value = item.id;
            el_cat_option.appendChild(option);
        }
    }

    //========================================获取product表中的数据
    function get_product_list() {
        $.get('./gateway.php?model=product&action=read')
            .then(function (r) {
                product_list = r.data;
                render_product_list();
            })
    }

    //===================================把product中的数据渲染到页面
    function render_product_list() {
        first_tbody.innerHTML = "";
        for (var i = 0; i < product_list.length; i++) {
            var ktr = document.createElement('tr');
            var item = product_list[i];
            ktr.innerHTML = `
            <td>${item.id}</td>  
            <td>${item.title}</td>  
            <td>${item.price}</td>  
            <td>${item.stock}</td>  
            <td>${item.cat_id}</td>  
            <td><button class="btn btn-danger" id="del_button_${item.id}"><i class="fa fa-trash"></i></button>
                 <button class="btn btn-success" id="up_button_${item.id}"><i class="fa fa-edit"></i></button>
            </td>  
            `;
            first_tbody.appendChild(ktr);
            var del_button = document.querySelector("#del_button_" + item.id);
            del_event(del_button, item.id);
            var up_button = document.querySelector("#up_button_" + item.id);
            up_data(up_button, item.id);
        }
    }

    //=========================================获取页面表单输入
    function get_page_input(el) {
        var data = {};
        var input_list = el.querySelectorAll('[name]');
        for (var i = 0; i < input_list.length; i++) {
            var input = input_list[i];
            var key = input.name;
            var val = input.value;
            input.value = "";
            data[key] = val;
        }
        return data;

    }

    //===============================================增加提交事件
    function add_submit() {
        my_form.addEventListener('submit', function (e) {
            e.preventDefault();
            var row = get_page_input(my_form);
            if (!row.id) {
                $.post('./gateway.php?model=product&action=add', row)
                    .then(function (r) {
                        if (r.success) {
                            get_product_list();
                        }
                    })
            } else {
                $.post('./gateway.php?model=product&action=update', row)
                    .then(function (r) {
                        console.log(r);
                        if (r.success) {
                            get_product_list();
                        }
                    })
            }

        })
    }

    //================================================增加删除事件
    function del_event(a, id) {
        a.addEventListener('click', function () {
            var ik = {};
            ik.id = id;
            $.post('./gateway.php?model=product&action=remove', ik)
                .then(function (r) {
                    console.log(r);
                    if (r.success) {
                        get_product_list();
                    }
                })
        })
    }

    //===============================================增加更新事件
    function up_data(a, id) {
        a.addEventListener('click', function () {
            var get_item;
            var aa = {};
            aa.id = id;
            //获取一条数据
            $.get('./gateway.php?model=product&action=read', aa)
                .then(function (r) {
                    get_item = r.data;
                    import_page(get_item);
                });
        })
    }

    //===============================================把值导到页面
    function import_page(data) {
        for (var item in data) {
            var val = data[item];
            var input = document.querySelector('[name=' + item + ' ]');
            if (!input) {
                continue;
            }
            input.value = val;
        }
    }

    //=================================================初始化函数
    function init() {
        get_cat_list();
        get_product_list();
        //增加提交事件
        add_submit();
        //删除事件

    }

    init();
})();