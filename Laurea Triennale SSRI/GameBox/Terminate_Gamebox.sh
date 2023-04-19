#!/usr/bin/env bash
for dir in ./Challenges/*/ ; do
  if [ -d "${dir}" ]; then
      cd $dir
      docker-compose down -v
      cd ../..
    fi
done
docker system prune -a
