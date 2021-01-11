<?php
session_start();
session_destroy();

echo "Logged out. Back to <a href=\"./\">home</a>.";
