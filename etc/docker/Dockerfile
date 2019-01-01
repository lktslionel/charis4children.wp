FROM bitnami/wordpress:latest
LABEL kompose.service.type=nodeport

COPY etc/docker/scripts/backup.sh /usr/local/bin/backup.sh
RUN chmod +x /usr/local/bin/backup.sh

COPY etc/docker/scripts/app-entrypoint.sh /app-entrypoint.sh
RUN chmod +x /app-entrypoint.sh

COPY etc/docker/scripts/run.sh /usr/local/bin/run.sh
RUN chmod +x /usr/local/bin/run.sh

ENTRYPOINT [ "/app-entrypoint.sh" ]
CMD "/usr/local/bin/run.sh"

