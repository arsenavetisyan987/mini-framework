LOG_DIR="/var/www/storage/logs"

mkdir -p "$LOG_DIR"

chown -R www-data:www-data "$LOG_DIR"

chmod -R 775 "$LOG_DIR"

echo "✅ Log directory permissions fixed: $LOG_DIR"