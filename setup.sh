#!/usr/bin/env bash
cp nginx.conf /etc/nginx/nginx.conf
docker-compose build
docker-compose up -d
nginx -s reload || nginx
