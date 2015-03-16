#!/bin/sh

find ../../../Volumes/jpg/1/ -mmin +10 -type f -name "*.jpg" -exec rm {} \;
find ../../../Volumes/tif/ -mmin +10 -type f -name "*.tif" -exec rm {} \;
