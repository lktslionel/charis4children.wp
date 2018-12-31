#!/bin/bash 

. /opt/bitnami/base/functions





# Starting application 
exec httpd -f /bitnami/apache/conf/httpd.conf -DFOREGROUND
