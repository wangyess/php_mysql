;(function () {
    'use strict';
    //分类数组
    var cat_list = [];
    //选中表单
    var cat_form = document.getElementById('cat-form');
    //下拉框
    var el_parent_id = document.querySelector('[name=parent_id');
    //选中tbody
    var cat_tbody = document.getElementById('cat-tbody');

    //获取分类中的数据
    function get_select_data() {
        $.get('./gateway.php?model=cat&action=read')
            .then(function (r) {
                cat_list = r.data;
                render_cat_list(cat_list);
                render_cat_list_div(cat_list);
            })
    }

    //把分类中的数据显视到页面
    function render_cat_list_div(data) {
        cat_tbody.innerHTML = "";
        data.forEach(function (item) {
            var tr = document.createElement('tr');
            tr.innerHTML = `
            <td>${item.id}</td>
            <td>${item.title}</td>
            <td>${item.parent_id}</td>
            <td>
            <button class="btn btn-danger" id="del_button_${item.id}"><i class="fa fa-trash"></i></button>
            <button class="btn btn-success" id="up_button_${item.id}"><i class="fa fa-edit"></i></button>
            </td>
            `;
            cat_tbody.appendChild(tr);
            var del_button = document.getElementById('del_button_' + item.id);
            del_event(del_button, item.id);
            var up_button = document.getElementById('up_button_' + item.id);
            up_event(up_button, item.id);
        })
    }

    //删除事件
    function del_event(a, id) {
        var b = {};
        b.id = id;
        a.addEventListener('click', function () {
            $.post('./gateway.php?model=cat&action=remove', b)
                .then(function (r) {
                    get_select_data();
                })
        })
    }

    //跟新事件
    function up_event(a, id) {
        var b = {};
        b.id = id;
        a.addEventListener('click', function () {
            //获取到这条更改的数据
            get_up_data(b);
        })
    }

    //获取到更改的这条数据
    function get_up_data(b) {
        $.get('./gateway.php?model=cat&action=read', b)
            .then(function (r) {
                var item_data = r.data;
                set_form_data(item_data);
            })
    }

    //把这条数据渲染到表单中
    function set_form_data(data) {
        for (var temp in data) {
            var input = document.querySelector('[name=' + temp + ']');
            input.value = data[temp];
        }
    }

    //把分类中的数据渲染到页面的select选项
    function render_cat_list(data) {
        el_parent_id.innerHTML = "";

        var a_op = document.createElement('option');
        a_op.innerHTML = "默认顶级分类";
        a_op.value = "";
        el_parent_id.appendChild(a_op);

        data.forEach(function (item) {
            var option = document.createElement('option');
            option.innerHTML = item.title;
            option.value = item.id;
            el_parent_id.appendChild(option);
        })
    }

    //给表单增加提交事件
    function submit_cat_form() {
        cat_form.addEventListener('submit', function (e) {
            e.preventDefault();
            //获取页面输入
            var b = get_input_data(cat_form);
            if (!b.id) {
                $.post('./gateway.php?model=cat&action=add', b)
                    .then(function (r) {
                        if (r.success) {
                            get_select_data();
                        }
                    })
            } else {
                $.post('./gateway.php?model=cat&action=update', b)
                    .then(function (r) {
                        if (r.success) {
                            get_select_data();
                        }
                    })
            }
        })
    }

    //获取表单输入
    function get_input_data(el) {
        var a = {};
        var input_list = el.querySelectorAll('[name]');
        input_list.forEach(function (input) {
            var val = input.value;
            var key = input.name;
            a[key] = val;
            input.value = "";
        })
        return a;
    }

    //初始化函数
    function init() {
        //获取分类数据 并渲染到select中
        get_select_data();
        //监听表单提交事件 如提交就启动一系列方法使得添加chengg
        submit_cat_form();
    }

    init();
})();