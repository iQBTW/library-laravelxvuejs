<?php

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
    if ($value == false) {
        return $value = "Belum dikembalikan";
    } else if ($value == true) {
        return $value = "Sudah dikembalikan";
    }
}
