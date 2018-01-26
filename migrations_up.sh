#!/bin/bash

./yii migrate --migrationPath=@yii/rbac/migrations
./yii migrate --migrationPath=@yii/i18n/migrations
./yii migrate


