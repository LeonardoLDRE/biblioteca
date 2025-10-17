<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function esc($str) {
  return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
