<?php
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function intParam(string $name, int $default): int {
    $value = filter_input(INPUT_GET, $name, FILTER_VALIDATE_INT);
    return $value !== false && $value !== null ? $value : $default;
}

function clampYear(int $year): int {
    return max(2020, min(2024, $year));
}

function percentWidth(int|float $value, int|float $max): float {
    if ($max <= 0) return 0;
    return max(2, min(100, ($value / $max) * 100));
}
