<?php
/**
 * Created by PhpStorm.
 * User: taoyu
 * Date: 9/18/2016
 * Time: 10:49 AM
 */

return [
    //to show the function of about showing customs
    'json' => 'json/ccbuy.json',
    //set validation rule for edit table as update data from backend
    'validation' => [
        'carts'     =>[
            'id'            => 'readOnly',
            'customs_id'    => 'foreignKey',
            'rename'        => 'required',
            'weight'        => 'money',
            'postRate'      => 'money',
            'profits'       => 'money',
            'date'          => ['date','required']
        ],
        'customs'   => [
            'id'            => 'readOnly',
            'customName'    => 'required',
            'relationship'  => 'required',
            'dgFrom'        => 'required',
            'info'          => ''
        ],
        'incomes'   => [
            'id'            => 'readOnly',
            'items_id'      => 'foreignKey',
            'moneyDue'      => 'money',
            'moneyReceived' => 'money',
            'moneyGain'     => 'money',
            'moneyToWhere'  => '',
            'info'          => ''
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
            'date'          => ['date','required'],
            'isDeal'        => 'bool',
            'itemPic'       => '',
            'info'          => ''
        ],
        'stores'    => [
            'id'            => 'readOnly',
            'storeName'     => 'required',
            'info'          => ''
        ],
        'users'     => [
            'id'            => 'readOnly',
            'name'          => 'required',
            'email'         => 'email',
            'password'      => 'password',
            'remember_token'=> 'readOnly',
            'created_at'    => 'readOnly',
            'updated_at'    => 'readOnly'
        ]
    ]
];