#!/bin/bash

skelDir="/data/jack/Dev/Projects/Filament/skel/"
wd=`pwd`

function usage() {
  echo "$0 <dir>" 
}

function install() {
  echo "Installing..."
  
  composer create-project laravel/laravel $projectDir

  cd $projectDir

  php artisan storage:link

  composer require livewire/livewire
  php artisan livewire:publish --config

  composer require symfony/sendinblue-mailer

  composer require ylsideas/feature-flags
  php artisan vendor:publish --provider="YlsIdeas\FeatureFlags\FeatureFlagsServiceProvider" --tag=config

  npm install
  npm install bootstrap@5.2.1
  
  cd $wd
}

function copyFiles() {
  echo "Copying files..."

}

function steps() {
  echo "Complete steps"

  echo "Update .env file"
  read -p "Press enter to continue" ans
  
  echo "Update db credentials en .env file"
  read -p "Press enter to continue" ans

  echo "Start server"
}

projectDir=$1

if [ "X${projectDir}" == "X" ]; then
  usage
  exit 1
fi

install

if [ "$?" == "0" ]; then
  copyFiles
  steps
fi
