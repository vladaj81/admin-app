<?php

return [
    'import_types' => [
        'orders' => [
            'label'                => 'Import Orders',
            'permissions_required' => 'import-orders',
            'files'                => [
                'file1' => [
                    'label'         => 'File 1',
                    'db_table'      => 'orders',
                    'headers_to_db' => [
                        'order_date' => [
                            'label'      => 'Order Date',
                            'type'       => 'date',
                            'validation' => ['required']
                        ],
                        'channel' => [
                            'label'      => 'Channel',
                            'type'       => 'string',
                            'validation' => ['required', 'in' => ['PT', 'Amazon']]
                        ],
                        'sku' => [
                            'label'      => 'SKU',
                            'type'       => 'string',
                            'validation' => ['required', 'exists' => ['table' => 'products', 'column' => 'sku']]
                        ],
                        'item_description' => [
                            'label'      => 'Item Description',
                            'type'       => 'string',
                            'validation' => ['nullable']
                        ],
                        'origin' => [
                            'label'      => 'Origin',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'so_num' => [
                            'label'      => 'SO#',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'cost' => [
                            'label'      => 'Cost',
                            'type'       => 'double',
                            'validation' => ['required']
                        ],
                        'shipping_cost' => [
                            'label'      => 'Shipping Cost',
                            'type'       => 'double',
                            'validation' => ['required']
                        ],
                        'total_price' => [
                            'label'      => 'Total Price',
                            'type'       => 'double',
                            'validation' => ['required']
                        ],
                    ],
                    'update_or_create' => ['so_num', 'sku'],
                ]
            ]
        ],
        'products' => [
            'label'                => 'Import Products',
            'permissions_required' => 'import-products',
            'files'                => [
                'file1' => [
                    'label'         => 'File 1',
                    'db_table'      => 'products',
                    'headers_to_db' => [
                        'sku' => [
                            'label'      => 'SKU',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'import_country' => [
                            'label'      => 'Import Country',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'price' => [
                            'label'      => 'Price',
                            'type'       => 'double',
                            'validation' => ['required']
                        ],
                        'product_description' => [
                            'label'      => 'Product Description',
                            'type'       => 'string',
                            'validation' => ['nullable']
                        ],
                    ],
                ],
                'file2' => [
                    'label'         => 'File 2',
                    'db_table'      => 'product_details',
                    'headers_to_db' => [
                        'sku' => [
                            'label'      => 'SKU',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'production_year' => [
                            'label'      => 'Production Year',
                            'type'       => 'int',
                            'validation' => ['required']
                        ],
                        'manufacturer' => [
                            'label'      => 'Manufacturer',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'detailed_description' => [
                            'label'      => 'Detailed Description',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                    ]
                ]
            ]
        ],
        'customers' => [
            'label'                => 'Import Customers',
            'permissions_required' => 'import-customers',
            'files'                => [
                'file1' => [
                    'label'         => 'File 1',
                    'db_table'      => 'customers',
                    'headers_to_db' => [
                        'customer_name' => [
                            'label'      => 'Customer Name',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'city' => [
                            'label'      => 'City',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'address' => [
                            'label'      => 'Address',
                            'type'       => 'string',
                            'validation' => ['required']
                        ],
                        'phone' => [
                            'label'      => 'Phone',
                            'type'       => 'string',
                            'validation' => ['nullable']
                        ],
                    ]
                ]
            ]
        ],
    ]
];