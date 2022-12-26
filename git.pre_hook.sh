#!/bin/bash

IN_MERGE=$(git rev-parse -q --verify MERGE_HEAD)
IN_REBASE=$(git rev-parse -q --verify REBASE_HEAD)
IN_CHERRY_PICKING=$(git rev-parse -q --verify CHERRY_PICK_HEAD)

if [ "$IN_MERGE" != "" ] || [ "$IN_REBASE" != "" ] || [ "$IN_CHERRY_PICKING" != "" ]; then
    exit 0;
fi

FILES=$(git diff-index --name-only --cached --diff-filter=ACMR HEAD -- '*.php' -- | cut -f2- -d\/ | grep -qv 'tests' | paste -s -d' ' -)

if [ "$FILES" == "" ]; then
  exit 0;
fi

echo "Running PHP CS Fixer"
docker-compose exec -T php sh -c "./vendor/bin/pint"

exit 0


