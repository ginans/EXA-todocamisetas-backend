#!/usr/bin/env bash
set -euo pipefail

if [[ "$(uname -s)" == "Linux" ]]; then
  UID="$(id -u)" GID="$(id -g)" docker compose -f docker-compose.yml -f docker-compose.linux.yml up -d --build
else
  docker compose up -d --build
fi
