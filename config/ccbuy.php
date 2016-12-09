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
            'id'            => '@id',
            'customs_id'    => '@customs_id',
            'rename'        => '@rename',
            'weight'        => '@weight',
            'postRate'      => '@postRate',
            'profits'       => '@profits',
            'isHelpBuy'     => '@isHelpBuy',
            'date'          => '@date'
        ],
        'customs'   => [
            'id'            => '@id',
            'customName'    => '@customName',
            'relationship'  => '@relationship',
            'dgFrom'        => '@dgFrom',
            'info'          => '@info'
        ],
        'incomes'   => [
            'id'            => '@id',
            'items_id'      => '@items_id',
            'moneyDue'      => '@moneyDue',
            'moneyReceived' => '@moneyReceived',
            'moneyGain'     => '@moneyGain',
            'moneyToWhere'  => '@moneyToWhere',
            'info'          => '@info'
        ],
        'items'     => [
            'id'            => '@id',
            'carts_id'      => '@carts_id',
            'stores_id'     => '@stores_id',
            'itemName'      => '@itemName',
            'itemAmount'    => '@itemAmount',
            'sellPrice'     => '@sellPrice',
            'specialPrice'  => '@specialPrice',
            'exchangeRate'  => '@specialPrice',
            'marketPrice'   => '@marketPrice',
            'costPrice'     => '@costPrice',
            'itemProfit'    => '@itemProfit',
            'date'          => '@date',
            'isDeal'        => '@isDeal',
            'itemPic'       => '@itemPic',
            'info'          => '@info'
        ],
        'stores'    => [
            'id'            => '@id',
            'storeName'     => '@storeName',
            'info'          => '@info'
        ],
        'users'     => [
            'id'            => '@id',
            'name'          => '@name',
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
     *  'fuzzySearch'   => '',      //fuzzy search
     */
    'search' => [
        'isShowSearch'  => 'true',
        //all table's rule for search
        'tables'        => [
            'carts'         => [    //if table is defined than it's attribute must be present which are 'isShow,tabTitles,tab'
                'isShow'    => 'true',
                'tabTitles' => [    //all the tab field=>showing title
                    'order'     => '@orderName',
                    'helpBuy'   => '@helpBuy',
                    'customer'  => '@customer',
                    'combined'  => '@combined'
                ],    //tabTitles's name must be the same with name under 'tab' to make sure the css which is showing on the page will be corrected
                'tab'       => [
                    'order'         => [
                        [
                            'columnName'    => 'rename',    //has to be database column name
                            'title'         => '@orderName',
                            'validation'    => 'none',
                            'fuzzySearch'   => 'true',
                        ]
                    ],
                    'helpBuy'      => [
                        [
                            'columnName'    => 'isHelpBuy',
                            'title'         => '@helpBuy',
                            'validation'    => 'bool',
                            'fuzzySearch'   => 'false',
                        ]
                    ],
                    'customer'      => [
                        [
                            'columnName'    => 'customs_id',
                            'title'         => '@customer',
                            'validation'    => 'foreignKey',
                            'fuzzySearch'   => 'false',
                        ]
                    ],
                    'combined'     => [
                        [
                        'columnName'    => 'customs_id',
                        'title'         => '@customer',
                        'validation'    => 'foreignKey',
                        'fuzzySearch'   => 'false',
                    ],[
                        'columnName'    => 'rename',
                        'title'         => '@orderName',
                        'validation'    => 'none',
                        'fuzzySearch'   => 'true',
                    ],[
                        'columnName'    => 'isHelpBuy',
                        'title'         => '@helpBuy',
                        'validation'    => 'bool',
                        'fuzzySearch'   => 'false',
                    ]
                    ],
                ],
            ],
            'customs'       => [
                'isShow'    => 'true',
                'tabTitles' => [
                    'customer'  => '@customer',
                ],
                'tab'       => [
                    'customer'  => [
                        [
                            'columnName'    => 'customName',
                            'title'         => '@customer',
                            'validation'    => 'none',
                            'fuzzySearch'   => 'true',
                        ],
                    ],
                ],
            ],
            'incomes'       => '',
            'items'         => [
                'isShow'    => 'true',
                'tabTitles' => [
                    'storeId'   => '@storeId',
                    'itemName'  => '@itemName',
                    'date'      => '@date',
                    'isDeal'    => '@isDeal',
                    'combined'  => '@combined',
                ],
                'tab'       => [
                    'storeId'    => [
                        [
                            'columnName'    => 'stores_id',
                            'title'         => '@storeId',
                            'validation'    => 'foreignKey',
                            'fuzzySearch'   => 'false'
                        ]
                    ],
                    'itemName'    => [
                        [
                            'columnName'    => 'itemName',
                            'title'         => '@itemName',
                            'validation'    => 'none',
                            'fuzzySearch'   => 'true'
                        ]
                    ],
                    'date'    => [
                        [
                            'columnName'    => 'date',
                            'title'         => '@date',
                            'validation'    => 'date',
                            'fuzzySearch'   => 'false'
                        ]
                    ],
                    'isDeal'    => [
                        [
                            'columnName'    => 'isDeal',
                            'title'         => '@isDeal',
                            'validation'    => 'bool',
                            'fuzzySearch'   => 'false'
                        ]
                    ],
                    'combined'    => [
                        [
                            'columnName'    => 'itemName',
                            'title'         => '@itemName',
                            'validation'    => 'none',
                            'fuzzySearch'   => 'true'
                        ],
                        [
                            'columnName'    => 'isDeal',
                            'title'         => '@isDeal',
                            'validation'    => 'bool',
                            'fuzzySearch'   => 'false'
                        ],
                    ],
                ],
            ],
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
            'profitAll'     => 'json/profitAll.json',
            'customer2016'  => 'json/customer2016.json',
            'customer2017'  => 'json/customer2017.json',
            'customerAll'   => 'json/customerAll.json',
            'allItem'       => 'json/allItem.json',
        ],
        'profitMonth'   => 'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
        'profitAll'     => '2016,2017,2018',
    ]
    #endregion
];