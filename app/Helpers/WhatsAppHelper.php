<?php

namespace App\Helpers;

class WhatsAppHelper
{
    public static function generateOrderMessage($items, $customerInfo, $transaction)
    {
        $config = config('store');
        $storeName = $config['whatsapp']['store_name'];
        
        $lines = [
            "*PESANAN BARU - {$storeName}*",
            "",
            "Halo Admin, saya ingin memesan buku berikut:",
            "",
        ];

        foreach ($items as $item) {
            $lines[] = "- *{$item->book->title}*";
            $lines[] = "- Penulis: {$item->book->author}";
            $lines[] = "- Jumlah: {$item->quantity}";
            $lines[] = "- Harga: Rp " . number_format($item->unit_price, 0, ',', '.');
            $lines[] = "";
        }

        $totalPrice = collect($items)->sum(function($item) {
            return $item->unit_price * $item->quantity;
        });

        $lines[] = "- *Total: Rp " . number_format($totalPrice, 0, ',', '.') . "*";
        $lines[] = "";
        $lines[] = "- *Nama Penerima:* {$customerInfo['receiver_name']}";
        $lines[] = "- *No. Telepon Penerima:* {$customerInfo['phone']}";
        $lines[] = "- *Alamat Pengiriman:* {$customerInfo['address']}";
        $lines[] = "";
        $lines[] = "- *Metode Pembayaran:* {$customerInfo['payment_method']}";
        $lines[] = "";

        if ($customerInfo['payment_method'] === 'COD') {
            $lines[] = "- " . $config['bank']['instructions']['COD'];
        } else {
            $lines[] = "- " . $config['bank']['instructions']['Transfer Bank'];
            $lines[] = "- {$config['bank']['details']}";
        }

        $lines[] = "";
        $lines[] = "- *Kode Transaksi:* #{$transaction->id}";
        $lines[] = "- *Tanggal:* " . now()->format('d/m/Y H:i');
        $lines[] = "";
        $lines[] = "Terima kasih, semoga harimu menyenangkan!";

        return implode("\n", $lines);
    }

    public static function generateWhatsAppUrl($message)
    {
        $config = config('store');
        $number = $config['whatsapp']['number'];
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$number}?text={$encodedMessage}";
    }

    public static function generateQuickOrderMessage($book, $quantity, $customerInfo)
    {
        $config = config('store');
        $storeName = $config['whatsapp']['store_name'];
        
        $totalPrice = $book->price * $quantity;
        
        $lines = [
            "🛒 *PESANAN CEPAT - {$storeName}*",
            "",
            "Halo Admin, saya ingin memesan buku berikut:",
            "",
            "- *{$book->title}*",
            "- Penulis: {$book->author}",
            "- Jumlah: {$quantity}",
            "- Harga: Rp " . number_format($book->price, 0, ',', '.'),
            "- Total: Rp " . number_format($totalPrice, 0, ',', '.'),
            "",
            "- *Nama Penerima:* {$customerInfo['receiver_name']}",
            "- *No. Telepon Penerima:* {$customerInfo['phone']}",
            "- *Alamat Pengiriman:* {$customerInfo['address']}",
            " ",
            "",
            "- *Metode Pembayaran:* {$customerInfo['payment_method']}",
            "",
        ];

        if ($customerInfo['payment_method'] === 'COD') {
            $lines[] = "ℹ️ " . $config['bank']['instructions']['COD'];
        } else {
            $lines[] = "ℹ️ " . $config['bank']['instructions']['Transfer Bank'];
            $lines[] = "🏦 {$config['bank']['details']}";
        }

        $lines[] = "";
        $lines[] = "- Tanggal: " . now()->format('d/m/Y H:i');
        $lines[] = "";
        $lines[] = "Terima kasih, semoga harimu menyenangkan!";

        return implode("\n", $lines);
    }
}
