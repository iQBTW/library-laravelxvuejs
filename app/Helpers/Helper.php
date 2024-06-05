<?php

use Carbon\Carbon;
use App\Models\User;
use Symfony\Component\Clock\now;

function convertDateTime($value)
{
    return date('H:i:s - d M Y', strtotime($value));
}

function convertDate($value)
{
    return date('d M Y', strtotime($value));
}

function is_Returned($value)
{
    if ($value == 'not_returned') {
        return $value = "Belum dikembalikan";
    }
    else if ($value == 'returned') {
        return $value = "Sudah dikembalikan";
    }
}

function checkDueTransactions($transactions)
{
    $dueTransactions = [];
    $currentDate = Carbon::now();

    foreach ($transactions as $transaction) {
        $dateEnd = Carbon::parse($transaction['date_end']);
        if ($currentDate->gt($dateEnd)) {
            // Menghitung jumlah hari keterlambatan dari date_end
            $daysLate = $dateEnd->diffInDays($currentDate);

            // Menentukan pesan keterlambatan berdasarkan jumlah hari keterlambatan
            if ($daysLate > 0) {
                $daysLate = floor($daysLate);
                $lateMessage = $daysLate . ' days' . ($daysLate > 1 ? 's' : '') . ' late';
            }

            // Memuat data pengguna terkait dengan transaksi
            $user = User::find($transaction['user_id']);
            $userName = $user ? $user->name : 'Unknown'; // Mengambil nama pengguna atau 'Unknown' jika tidak ditemukan

            // Tambahkan pesan keterlambatan ke dalam array transaksi
            $transaction['late_message'] = $lateMessage;
            $transaction['user_name'] = $userName;

            // Tambahkan transaksi ke dalam array $dueTransactions
            $dueTransactions[] = $transaction;
        }
    }

    return $dueTransactions;
}
