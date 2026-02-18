#!/bin/bash

# Kill any existing PHP server on port 8000
lsof -ti:8000 | xargs kill -9 2>/dev/null

# Start PHP server
cd "$(dirname "$0")"
php -S localhost:8000 -t public
