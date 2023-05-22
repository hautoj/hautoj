FROM ubuntu:18.04

ARG DEBIAN_FRONTEND=noninteractive
ARG TZ=Asia/Shanghai

COPY trunk/install/sources.list.sh /opt/sources.list.sh

# Linux: Aliyun Apt Mirrors.
RUN set -ex \
    && bash /opt/sources.list.sh \
    && apt-get -y update \
    && apt-get -y install --no-install-recommends \
        nginx \
        php-common \
        php-fpm \
        php-mysql \
        php-gd \
        php-zip \
        php-mbstring \
        php-xml \
        php-memcache \
        php-memcached \
        php-redis \
        ca-certificates \
        tzdata \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata \
    && rm -rf /var/lib/apt/lists/*

COPY trunk/ /trunk/

COPY docker/ /opt/docker/

RUN bash /opt/docker/web/setup.sh

# sharing data volume with judge container
VOLUME [ "/home/judge/data" ]

ENTRYPOINT [ "/bin/bash", "/opt/docker/web/entrypoint.sh" ]
