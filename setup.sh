#!/bin/bash

# Start the first process
php src/ws-server.php &

# Start the second process
cd public && pwd && php -S 0.0.0.0:8000 &

# Wait for any process to exit
wait -n

# Exit with status of process that exited first
exit $?