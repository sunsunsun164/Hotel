#!/bin/sh

addgroup \
        -g $GID \
        -S \
        $FTP_USER

adduser \
        -D \
        -G $FTP_USER \
        -h /mnt/$FTP_DIR \
        -s /bin/false \
        -u $UID \
        $FTP_USER

mkdir -p /mnt/$FTP_DIR
chown -R $FTP_USER:$FTP_USER /mnt/$FTP_DIR
echo "$FTP_USER:$FTP_PASS" | /usr/sbin/chpasswd

touch /var/log/vsftpd.log
tail -f /var/log/vsftpd.log | tee /dev/stdout &
touch /var/log/xferlog
tail -f /var/log/xferlog | tee /dev/stdout &

/usr/sbin/vsftpd
