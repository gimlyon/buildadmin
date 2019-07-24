define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'douyin/giftrank/index' + location.search,
                    add_url: 'douyin/giftrank/add',
                    edit_url: 'douyin/giftrank/edit',
                    del_url: 'douyin/giftrank/del',
                    multi_url: 'douyin/giftrank/multi',
                    table: 'douyin_gift_rank',
                    export_url: 'giftrank/export',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'display_id', title: __('Display_id'), sortable:true, operate: 'LIKE'},
                        {field: 'short_id', title: __('Short_id'), sortable:true, operate: 'LIKE'},
                        {field: 'room_id', title: __('Room_id'), sortable:true, operate: 'LIKE'},
                        {field: 'nickname', title: __('Nickname'), sortable:true, operate: 'LIKE'},
                        {field: 'rank', title: __('Rank'), sortable:true, operate: false},
                        {field: 'score', title: __('Score'), sortable:true},
                        // {field: 'avatar_thumb', title: __('Avatar_thumb'), formatter: function (value, row, index) {
                        //     return '<a href="' + value + '" target="_blank"><img src="' + value + '" height="30" /></a>';
                        // }},
                        // {field: 'icon_level', title: __('Icon_level'), formatter: Table.api.formatter.image, sortable:true},
                        {field: 'remark', title: __('Remark'), operate: 'LIKE'},
                        {field: 'state', title: __('State'), searchList: {"1":__('State 1'),"2":__('State 2')}, formatter: Table.api.formatter.normal, sortable:true},
                        {field: 'ranktime', title: __('Ranktime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime, sortable:true},
                        // {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        // {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ],
                showToggle: false,
                showExport: false,
                search: false, //是否启用快速搜索
                pageList: [15, 30, 50, 100],
                pageSize: 15,
                undefinedText: '',
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
            
            // 导出
            $('.btn-export').click(function () {
                table.bootstrapTable('refresh', {
                    url: $.fn.bootstrapTable.defaults.extend.export_url
                });
                $('.fa-spin').removeClass("fa-spin");
                table.bootstrapTable('refresh', {
                    url: $.fn.bootstrapTable.defaults.extend.index_url
                });
            });
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});