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
                        {field: 'id', title: __('Id')},
                        {field: 'display_id', title: __('Display_id')},
                        {field: 'short_id', title: __('Short_id')},
                        {field: 'room_id', title: __('Room_id')},
                        {field: 'nickname', title: __('Nickname')},
                        {field: 'rank', title: __('Rank')},
                        {field: 'score', title: __('Score')},
                        {field: 'avatar_thumb', title: __('Avatar_thumb'), formatter: Table.api.formatter.image},
                        {field: 'icon_level', title: __('Icon_level'), formatter: Table.api.formatter.image},
                        {field: 'remark', title: __('Remark')},
                        {field: 'state', title: __('State'), searchList: {"1":__('State 1'),"0":__('State 0')}, formatter: Table.api.formatter.normal},
                        {field: 'ranktime', title: __('Ranktime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        // {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        // {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
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