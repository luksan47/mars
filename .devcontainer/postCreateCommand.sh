#!/bin/bash

# Download anything necessary
apt-get update
apt-get install -y curl vim

# update bashrc
cat ./.devcontainer/bashrc-additions.sh >> ~/.bashrc

# Migrate and seed database 
php artisan migrate:fresh --seed

# Compile frontend
npm run dev