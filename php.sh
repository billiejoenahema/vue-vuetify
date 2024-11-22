#!/bin/sh

docker compose exec app php "$@"  # PHPが実行可能なコンテナを指定する
return $?
