set -xe

chown -R www-data:www-data /home/judge/data
chown -R www-data:www-data /var/log/hustoj/

ln -sf /dev/stdout /var/log/nginx/access.log
ln -sf /dev/stderr /var/log/nginx/error.log

service php7.2-fpm start
nginx -g "daemon off;"
