<?php

function convertDateTime($value)
{
    return date('H:i:s - d M Y', strtotime($value));
}

function convertDate($value)
{
    return date('d M Y', strtotime($value));
}

function upperCase($value)
{
    return ucfirst($value);
}
