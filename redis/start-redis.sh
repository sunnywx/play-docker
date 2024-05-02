#!/usr/bin/env bash

set -ex

#start a testing instance
docker run --name myredis -d redis

#use a new instance to connect above redis
# map above myredis into current container, check /etc/hosts, or ping redis
docker run --rm -it --link myredis:redis redis bash

# dump redis saved data into host dir
docker run --rm --volumes-from myredis -v $(pwd)/backup:/backup debian cp /data/dump.rdb /backup/
ls backup
