#!/usr/bin/env bash
# Respaldo de San Luquitas Digital: Moodle (MariaDB + moodledata) y Laravel (PostgreSQL + storage)
set -euo pipefail

PROYECTO=/opt/sanluquitas
DESTINO_BASE=/opt/backups
RETENCION_DIAS=7

cd "$PROYECTO"
FECHA=$(date +%F_%H%M)
DEST="$DESTINO_BASE/$FECHA"
mkdir -p "$DEST"
chmod 700 "$DEST"

echo "[$(date '+%F %T')] Inicio del respaldo -> $DEST"

# 1. Base de datos de Moodle (MariaDB), en caliente
docker compose exec -T moodle-db sh -c \
  'mariadb-dump -uroot -p"$MARIADB_ROOT_PASSWORD" --single-transaction --routines --triggers "$MARIADB_DATABASE"' \
  | gzip > "$DEST/moodle-db.sql.gz"
echo "  ✔ moodle-db.sql.gz"

# 2. Base de datos de Laravel (PostgreSQL)
docker compose exec -T laravel-db sh -c \
  'pg_dump -U "$POSTGRES_USER" -d "$POSTGRES_DB" --clean --if-exists' \
  | gzip > "$DEST/laravel-db.sql.gz"
echo "  ✔ laravel-db.sql.gz"

# 3. Archivos de Moodle (volumen moodledata), sin cachés regenerables
docker run --rm \
  -v sanluquitas_moodledata:/data:ro \
  -v "$DEST":/backup \
  alpine tar czf /backup/moodledata.tar.gz -C /data \
    --exclude=./cache --exclude=./localcache --exclude=./temp \
    --exclude=./sessions --exclude=./trashdir .
echo "  ✔ moodledata.tar.gz"

# 4. Archivos subidos al portal Laravel
tar czf "$DEST/laravel-storage.tar.gz" -C laravel storage/app
echo "  ✔ laravel-storage.tar.gz"

# 5. Configuración con secretos (necesaria para restaurar)
tar czf "$DEST/config-secretos.tar.gz" .env laravel/.env
chmod 600 "$DEST"/*
echo "  ✔ config-secretos.tar.gz"

# 6. Rotación: borrar respaldos con más de N días
find "$DESTINO_BASE" -mindepth 1 -maxdepth 1 -type d -mtime +$RETENCION_DIAS -exec rm -rf {} +
echo "  ✔ Rotación aplicada (se conservan $RETENCION_DIAS días)"

# 7. Copia cifrada en Google Drive (restic + rclone)
export RESTIC_REPOSITORY=rclone:gdrive:sanluquitas-backups
export RESTIC_PASSWORD_FILE="$HOME/.config/restic/password"

restic backup "$DEST" --tag sanluquitas --host sanluquitas-srv --quiet
echo "  ✔ Subido a Google Drive (cifrado)"

# Retención en la nube: 7 diarios, 4 semanales, 3 mensuales
restic forget --tag sanluquitas --keep-daily 7 --keep-weekly 4 --keep-monthly 3 --prune --quiet
echo "  ✔ Retención en la nube aplicada"

echo "[$(date '+%F %T')] Respaldo completado: $(du -sh "$DEST" | cut -f1)"
