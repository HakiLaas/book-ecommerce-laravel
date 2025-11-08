<?php

return [
    'whatsapp' => [
        'number' => env('WHATSAPP_NUMBER', '6281234567890'),
        'store_name' => env('STORE_NAME', 'Econic Book Store'),
        'store_address' => env('STORE_ADDRESS', 'Jl. Contoh No. 123, Jakarta'),
        'store_phone' => env('STORE_PHONE', '021-12345678'),
    ],
    
    'bank' => [
        'details' => env('BANK_DETAILS', 'BCA 1234567890 a/n Econic Book Store'),
        'instructions' => [
            'COD' =>':Pembayaran dilakukan saat barang diterima (COD). Pastikan Anda berada di alamat yang tertera saat kurir datang.',
            'Transfer Bank' =>': Silakan transfer ke rekening berikut dan kirimkan bukti transfer via WhatsApp:'
        ]
    ],
    
    'shipping' => [
        'free_threshold' => 500000, // Free shipping above this amount
        'default_cost' => 15000,
        'estimated_days' => '1-3 hari kerja'
    ]
];
