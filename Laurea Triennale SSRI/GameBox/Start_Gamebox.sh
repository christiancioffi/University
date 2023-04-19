#!/usr/bin/env bash
for dir in ./Challenges/*/ ; do
  if [ -d "${dir}" ]; then
      cd $dir
      docker-compose up -d
      cd ../..
    fi
done
