FROM alpine:3.20.3
ENV FTP_USER=hiddenuser \
        FTP_PASS=barcode \
        FTP_DIR=storage/app/imports \
        GID=1000 \
        UID=1000

RUN apk add --no-cache --update \
        vsftpd==3.0.5-r2

COPY ./docker/production/ftp/vsftpd.conf /etc
COPY ./docker/production/ftp/vsftpd-entrypoint.sh /
RUN  chmod +x /vsftpd-entrypoint.sh

ENTRYPOINT [ "/vsftpd-entrypoint.sh" ]
EXPOSE 20/tcp 21/tcp 40000-40009/tcp
HEALTHCHECK CMD netstat -lnt | grep :21 || exit 1
