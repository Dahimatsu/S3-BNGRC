<?php
function formatText($text): string
{
    return nl2br(htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8'));
}

function isInvalid($field, $errors): string
{
    return $errors[$field] !== '' ? 'is-invalid' : '';
}

function formatNumber($number): string
{
    return number_format($number, 2, ',', ' ');
}