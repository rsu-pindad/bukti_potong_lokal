#FROM redis:alpine
FROM redis:7.4-bookworm
WORKDIR /redis
# docker-compose volume
# COPY redis.conf /usr/local/etc/redis/redis.conf
COPY ./dev/docker-compose/redis/init.sh /redis/init.sh
RUN chmod +x /redis/init.sh