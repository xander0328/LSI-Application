<?php

// Call the Artisan command via exec()
exec('php artisan route:cache');

// Output a message to confirm
echo "Routes cached successfully!";