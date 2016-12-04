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
    //database name
    'database'      => env('DB'),
    'database_demo' => env('DB_DEMO'),
    'currentDatabase'=> env('DB_DATABASE'),
    //set how many items will be showing on page
    'page'          => [
        'firstPage'     => 8,
        'collecting'    => 20,
        'cartSelect'    => 5,
    ],

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
        'isHelpBuy'     => 'bool',
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
        'carts_id'      => 'int',
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
            'isHelpBuy'     => '是否代买',
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
    /* on the back end table edit pages , use for located which column will be showing on the drop down list
       'tableName' => 'showingField'    - if 'id' of table A as a foreign key is showing on table B, than 'showingField' will be showing on the output of drop down list
    */
    'dropDownName'  => [
        'carts'     => 'rename',
        'customs'   => 'customName',
        'incomes'   => '',
        'items'     => 'itemName',
        'stores'    => 'storeName',
        'users'     => 'name'
    ],
    //show which field(column) will be showing - all the table name array must be present when you new table (class) and showColum as a parameter
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
                    'field' => [    //use for showing on the output page
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
    /*special operation (only focus on the effect of data change) like delete one record from A table, than the data of a record from table B will be changed. the role can be customized
      every table including a update and delete which is showing when update or delete action is occur than the field value will be transferred
    */
    'special'       => [
        'items'     => [    //every element in the 'update or delete' will be transferred into delete action as hidden field
            'update'    => [],
            'delete'    => ['carts_id', 'itemProfit'],
        ],
    ],
    /*
     * search on table
     *  'title'         => '',      //show the name on the search page
     *  'columnName'    => '',      //field name use for to do search on database
     *  'validation'    => '',      //make a validation rule for the search area
     *  'isForeignKey'  => '',      //if is foreign key then will be showing the drop down list to do the search
     */
    'search' => [
        'isShowSearch'  => 'true',
        //all table's rule for search
        'tables'        => [
            'carts'         => [    //if table is defined than it's attribute must be present which are 'isShow,tabTitles,tab'
                'isShow'    => 'true',
                'tabTitles' => ['订单名称', '是否代买', '客户名称', '组合搜索'],    //tabTitles's name must be the same with name under 'tab' to make sure the css which is showing on the page will be corrected
                'tab'       => [
                    '订单名称'      => [
                        [
                            'columnName'    => 'rename',
                            'title'         => '订单名称',
                            'validation'    => 'required',
                            'isForeignKey'  => 'false',
                        ]
                    ],
                    '是否代买'      => [
                        [
                            'columnName'    => 'isHelpBuy',
                            'validation'    => 'bool',
                            'isForeignKey'  => 'false',
                        ]
                    ],
                    '客户名称'      => [
                        [
                            'columnName'    => 'customs_id',
                            'validation'    => 'foreignKey',
                            'isForeignKey'  => 'true',
                        ]
                    ],
                    '组合搜索'      => [
                        [
                            'columnName'    => 'customs_id',
                            'validation'    => 'foreignKey',
                            'isForeignKey'  => 'false',
                        ],[
                            'columnName'    => 'rename',
                            'validation'    => 'required',
                            'isForeignKey'  => 'false',
                        ],[
                            'columnName'    => 'isHelpBuy',
                            'validation'    => 'bool',
                            'isForeignKey'  => 'false',
                        ]
                    ],
                ],
            ],
            'customs'       => [],
            'incomes'       => '',
            'items'         => '',
            'stores'        => '',
            'users'         => '',
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