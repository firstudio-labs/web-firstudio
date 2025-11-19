#!/bin/bash

echo "Restarting Laravel server with increased PHP limits..."

# Kill existing server if running
pkill -f "php artisan serve"

# Wait a moment
sleep 2

# Start server with custom PHP configuration
php -c php.ini artisan serve --host=127.0.0.1 --port=8000

echo "Server restarted with increased limits:"
echo "- post_max_size: 32M"
echo "- upload_max_filesize: 32M"
echo "- max_input_vars: 3000"
echo "- memory_limit: 512M"
