<?php



$db_type = "mysql";
$db_host = "localhost";
$db_name = "bubble_tea";
$db_username = "root";


$folder_components = "/components";
$not_found = "{$folder_components}/not_found.php";


$default_user_avatar = "no_avatar.png";
$default_menu_image = "no_image_menu.png";


$menu_folder = "menu";
$users_folder = "users";



$sections = [
    "Клієнти" => [
        "type" => [
            "view" => ["section" => "client_list"],
            "edit" => ["section" => "client"]
        ]
    ],
    "Меню" => [
        "type" => [
            "view" => ["section" => "menu_list"],
            "edit" => ["section" => "menu"]
        ]
    ],
    "Статуси" => [
        "type" => [
            "view" => ["section" => "order_status_list"],
            "edit" => ["section" => "order_status"]
        ]
    ],
    "Замовлення" => [
        "type" => [
            "view" => ["section" => "order_list"],
            "edit" => ["section" => "order"]
        ]
    ]
];


