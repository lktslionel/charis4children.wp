#!/bin/bash 

. /opt/bitnami/base/functions

# check_errors: Check if the previous command fails
# params
#   - retcode int 
function Check_errors() {
  local _code=$1
  shift
  local _message="${*}"
  [[ "$_code" != "0" ]] && error "Fail - $_message" && exit 1
}


__BACKUP_ARCHIVE_FILENAME="abw.db.$(date +"%Y%m%d").sql.tgz"
__BACKUPS_DIR="/backups"

cd /bitnami

log "Starting db backup..."
sudo -u bitnami /opt/bitnami/wp-cli/bin/wp db export
Check_errors $?

log "Creating db archive..."
tar -czf $__BACKUP_ARCHIVE_FILENAME ./*.sql
Check_errors $?


log "Removing all sql files"
rm -rvf ./*.sql

log "Moving archive to backups dir"
mv -v $__BACKUP_ARCHIVE_FILENAME $__BACKUPS_DIR

log "Backup completed!"