#!/bin/bash
sudo rm -fr storage/debugbar/*
sudo rm -fr storage/logs/*
sudo rm -fr storage/framework/sessions/*
sudo rm -fr  storage/framework/views/*
sudo rm -fr storage/framework/cache/*

/bin/tar -czf pmd.tgz app bootstrap config database lib public resources/assets resources/lang resources/views storage tests README.md Dockerfile .env.docker 000-default.conf composer.json package.json bower.json gulpfile.js artisan liquibase liquibase.jar phpspec.yml phpunit.xml server.php 
