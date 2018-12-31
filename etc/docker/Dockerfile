FROM bitnami/wordpress:latest

LABEL kompose.service.type=nodeport




COPY scripts/run.sh /usr/local/bin/run.sh
RUN chmod +x /usr/local/bin/run.sh
CMD "/usr/local/bin/run.sh"