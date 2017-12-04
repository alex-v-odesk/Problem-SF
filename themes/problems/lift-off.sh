#!/bin/bash
sudo npm install -g gulp bower
npm install
bower install
npm install compass-mixins --save-dev
npm install gulp-sass-glob --save-dev
gulp
gulp watch