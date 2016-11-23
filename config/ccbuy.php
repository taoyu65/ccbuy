<?php
/**
 * Created by PhpStorm.
 * User: taoyu
 * Date: 9/18/2016
 * Time: 10:49 AM
 */

return [
    //to show the function of about showing customs
    'json'          => 'json/ccbuy.json',

    #region backend table edit
    //set validation rule for edit table as update data from backend
    'validation'    => [
        'carts'     => [
        'id'            => 'readOnly',
        'customs_id'    => 'foreignKey',
        'rename'        => 'required',
        'weight'        => 'money',
        'postRate'      => 'money',
        'profits'       => 'money',
        'date'          => 'date'
    ],
        'customs'   => [
        'id'            => 'readOnly',
        'customName'    => 'required',
        'relationship'  => 'required',
        'dgFrom'        => 'required',
        'info'          => 'none'
    ],
        'incomes'   => [
        'id'            => 'readOnly',
        'items_id'      => 'foreignKey',
        'moneyDue'      => 'money',
        'moneyReceived' => 'money',
        'moneyGain'     => 'money',
        'moneyToWhere'  => '',
        'info'          => 'none'
    ],
        'items'     => [
        'id'            => 'readOnly',
        'carts_id'      => 'foreignKey',
        'stores_id'     => 'foreignKey',
        'itemName'      => 'required',
        'itemAmount'    => 'required',
        'sellPrice'     => 'money',
        'specialPrice'  => 'money',
        'exchangeRate'  => 'money',
        'marketPrice'   => 'money',
        'costPrice'     => 'money',
        'itemProfit'    => 'money',
        'date'          => 'date',
        'isDeal'        => 'bool',
        'itemPic'       => '',
        'info'          => 'none'   //no rule
    ],
        'stores'    => [
        'id'            => 'readOnly',
        'storeName'     => 'required',
        'info'          => ''
    ],
        'users'     => [
        'id'            => 'readOnly',
        'name'          => 'readOnly',
        'email'         => 'readOnly',
        'password'      => 'readOnly',
        'remember_token'=> 'readOnly',
        'created_at'    => 'readOnly',
        'updated_at'    => 'readOnly'
    ]
    ],
    //showing the title for easier to read the column name
    'rename'        => [
        'carts'     =>[
            'id'            => 'ID',
            'customs_id'    => '客户ID',
            'rename'        => '订单名称',
            'weight'        => '重量',
            'postRate'      => '邮费每磅',
            'profits'       => '订单利润',
            'date'          => '日期'
        ],
        'customs'   => [
            'id'            => 'ID',
            'customName'    => '客户姓名',
            'relationship'  => '客户关系',
            'dgFrom'        => '客户来源',
            'info'          => '备注'
        ],
        'incomes'   => [
            'id'            => 'ID',
            'items_id'      => '物品ID',
            'moneyDue'      => '金额应付',
            'moneyReceived' => '金额实收',
            'moneyGain'     => '利润',
            'moneyToWhere'  => '金额去向',
            'info'          => '备注'
        ],
        'items'     => [
            'id'            => 'ID',
            'carts_id'      => '订单ID',
            'stores_id'     => '商店ID',
            'itemName'      => '物品名称',
            'itemAmount'    => '物品数量',
            'sellPrice'     => '出售金额',
            'specialPrice'  => '促销金额',
            'exchangeRate'  => '汇率转换',
            'marketPrice'   => '市场价格',
            'costPrice'     => '成本价格',
            'itemProfit'    => '实际盈利',
            'date'          => '日期',
            'isDeal'        => '是否结算',
            'itemPic'       => '物品图片',
            'info'          => '备注'
        ],
        'stores'    => [
            'id'            => 'ID',
            'storeName'     => '商店名称',
            'info'          => '备注'
        ],
        'users'     => [
            'id'            => 'ID',
            'name'          => '登录名称',
            'email'         => '邮箱名称',
            'password'      => '密码',
            'remember_token'=> '',
            'created_at'    => '',
            'updated_at'    => ''
        ]
    ],
    //on the back end table edit pages , use for located which column will be showing on the drop down list
    'dropDownName'  => [
        'carts'     => 'rename',
        'customs'   => 'customName',
        'incomes'   => '',
        'items'     => 'itemName',
        'stores'    => 'storeName',
        'users'     => 'name'
    ],
    //show which field(column) will be showing
    'showColumn'    => [
        'carts'     => '*',
        'customs'   => '*',
        'incomes'   => '*',
        'items'     => '*',//['id','itemName','sellPrice','costPrice','itemProfit','date','isDeal'],
        'stores'    => '*',
        'users'     => 'id,name'
    ],
    /* config the relationship of deletion either interlock (one table data belongs another) or checking the item is going to be deleted see if still has relation in another table
     * interlock - when delete record of table A, than all records will be deleted in table B which have foreign key of deletion of record (may interlock multiple table)
     *           - 'field' : in the warning box which field will be showing
     * existing - when delete record of table A, than check to see if there is a record in table B has table A's foreign key, if do than cancel deletion.
     */
    'delete'        => [
        'carts' => [
            'interlock' => [
                'items' => [
                    'field' => [
                        'id' => 'ID',
                        'itemName' => '物品名称',
                        'sellPrice' => '出售金额',
                        'date' => '日期'
                    ]
                ]
            ]
        ],
        'customs' => [
            'existing' => 'carts'
        ],
        'stores' => [
            'existing' => 'items'
        ]
    ],
    //special operation (only focus on the effect of data change) like delete one record from A table, than the data of a record from table B will be changed. the role can be customized
    'special'       => [
        'items'     => [
            'update'    => '',
            //every element in the 'delete' will be transferred into delete action as hidden field
            'delete'    => ['carts_id', 'itemProfit'],
        ],
    ],
    #endregion

    #region statistic
    'statistic' => [
        //json file use for cache data
        'profitsPath' => [
            'profit2016'    => 'json/profit2016.json',
            'profit2017'    => 'json/profit2017.json',
            'profitall'     => 'json/profitAll.json',
            'custom2016'    => 'json/custom2016.json',
            'custom2017'    => 'json/custom2017.json',
            'customAll'     => 'json/customAll.json',
        ],
        'profitMonth'   => 'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
        'profitAll'     => '2016,2017',
    ]
    #endregion
];