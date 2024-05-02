#!/usr/bin/env sh

set -ex

docker run --rm --name hello-web  -p 5000:5000 play-docker/hello-web