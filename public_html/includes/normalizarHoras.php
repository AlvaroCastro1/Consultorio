<?php
function normalize_hour($hour) {
    $parts = explode(':', $hour);
    return sprintf('%02d:%02d', $parts[0], $parts[1]);
}
?>