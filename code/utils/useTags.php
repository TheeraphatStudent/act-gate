<?php

$tags = [
    "online" => ["text" => "ONLINE", "background" => "bg-light-secondary", "color" => "text-secondary"],
    "onsite" => ["text" => "ONSITE", "background" => "bg-light-green", "color" => "text-primary"],
    "paid" => ["text" => "PAID", "background" => "bg-purple-100", "color" => "text-purple-600"],
    "free" => ["text" => "FREE", "background" => "bg-light-yellow", "color" => "text-dark-yellow"]
];

$statusMappings = [
    1 => ['class' => 'text-white btn-warring', 'label' => 'รออนุมัติ'],
    2 => ['class' => 'text-white btn-secondary', 'label' => 'อนุมัติแล้ว'],
    3 => ['class' => 'text-white btn-gray', 'label' => 'เคยเข้าร่วมแล้ว'],
    4 => ['class' => 'text-white btn-danger', 'label' => 'ถูกปฏิเสธ'],
    5 => ['class' => 'text-primary hover:text-white btn-primary-outline', 'label' => 'เข้าร่วมแล้ว'],
];

$attButtons = [
    'accepted' => [
        ['class' => 'btn-primary w-full', 'label' => 'แสดงบัตร', 'id' => 'acceptEvent'],
        // ['class' => 'btn-primary-outline w-full', 'label' => 'ดาวน์โหลดบัตร', 'id' => 'downloadTicket']
    ],
    'pending' => [
        ['class' => 'btn-warring w-full', 'label' => 'รออนุมัติ', 'id' => 'pendingEvent']
    ],
    'reject' => [
        ['class' => 'btn-danger w-full', 'label' => 'ดูเหตุผล', 'id' => 'rejectEvent']
    ],
    'default' => [
        ['class' => 'btn-primary w-full', 'label' => 'เข้าร่วม', 'id' => 'registerEvent']
    ],
    'full' => [
        ['class' => 'btn-gray w-full', 'label' => 'เต็ม', 'id' => '']
    ],
    'owned' => [
        ['class' => 'btn-primary-outline text-primary hover:text-white w-full', 'label' => 'คุณเป็นเจ้าของกิจกรรม', 'id' => '']
    ]
];