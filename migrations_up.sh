#!/bin/bash

yes | ./yii migrate --migrationPath=@yii/rbac/migrations
yes | ./yii migrate --migrationPath=@yii/i18n/migrations
yes | ./yii migrate


