#!/bin/bash

# Remote MySQL Connection Details
DB_HOST="82.25.121.81"
DB_USER="u463483684_marketvry"
DB_PASS="YogiiXmarketvryXgovind1@"
DB_NAME="u463483684_marketvry"

echo "Importing schema to remote database..."
mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME < schema.sql

if [ $? -eq 0 ]; then
    echo "✅ Database tables created successfully!"
else
    echo "❌ Error creating tables"
fi
