#!/bin/bash 

. /opt/bitnami/base/functions


__USER=bitnami
__GROUP=daemon

log "Fix permissions"
chown -R $__USER:$__GROUP /opt/bitnami/wordpress/ /bitnami


# Starting application 
exec httpd -f /bitnami/apache/conf/httpd.conf -DFOREGROUND
