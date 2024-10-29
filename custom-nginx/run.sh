#!/bin/bash

# docker build -t play-docker/custom-nginx .

docker run --rm -p 8090:80 -v .:/usr/share/nginx/html play-docker/custom-nginx