FROM ubuntu:18.04

ARG DEBIAN_FRONTEND=noninteractive
ARG TZ=Asia/Shanghai

COPY trunk/install/sources.list.sh /opt/sources.list.sh

# Linux: Aliyun Apt Mirrors.
RUN set -ex \
    && bash /opt/sources.list.sh \
    && apt-get -y update \
    && apt-get -y install --no-install-recommends \
        curl \
        tzdata \
        libmysqlclient-dev \
        libmysql++-dev \
        make \
        flex \
        gcc \
        g++ \
        openjdk-11-jdk \
        fp-compiler \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata \
    && rm -rf /var/lib/apt/lists/*

# Install Go compiler.
ARG GO_VERSION=1.13.15
RUN set -ex \
    && mkdir -p /opt/golang \
    && curl -sSL "https://go.dev/dl/go${GO_VERSION}.linux-amd64.tar.gz" | tar -v -C /opt/golang -xz --strip-components=1 \
    && ln -s /opt/golang/bin/go /usr/bin/go

# Install Python (miniforge3)
ARG MINIFORGE_VERSION=22.9.0-2
RUN set -ex \
    && curl -sSL -o /tmp/miniforge.sh "https://github.com/conda-forge/miniforge/releases/download/${MINIFORGE_VERSION}/Miniforge3-${MINIFORGE_VERSION}-Linux-x86_64.sh" \
    && bash /tmp/miniforge.sh -b -p /opt/miniforge3 \
    && pushd /opt/miniforge3/bin \
        `# 删除 miniforge3 下除了 python 外的可执行文件，以免被恶意利用` \
        && rm !(python*) \
    && popd \
    && rm -f /tmp/miniforge.sh \
    && ln -s /opt/miniforge3/bin/python3 /usr/bin/python3

COPY trunk /trunk

COPY docker/ /opt/docker/

RUN bash /opt/docker/judge/setup.sh

# sharing data volume with web container
VOLUME [ "/home/judge/data" ]

ENV HOSTNAME=localhost

ENV DATABASE=jol

ENV USERNAME=root

ENV PASSWORD=root

ENTRYPOINT [ "/bin/bash", "/opt/docker/judge/entrypoint.sh" ]
