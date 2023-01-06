#!/bin/bash

skelDir="/home/jack/Dev/Projects/Filament/skel/"
wd=`pwd`

function usage() {
  echo "$0 <dir>" 
}

function install() {
  echo "Installing..."
  
  composer create-project laravel/laravel $projectDir

  cd $projectDir

  php artisan storage:link

  composer require doctrine/dbal
  composer require barryvdh/laravel-debugbar --dev

  composer require opcodesio/log-viewer
  php artisan vendor:publish --tag="log-viewer-config"

  composer require psr/simple-cache:^2.0 maatwebsite/excel

  composer require symfony/sendinblue-mailer

  composer require ylsideas/feature-flags
  php artisan vendor:publish --provider="YlsIdeas\FeatureFlags\FeatureFlagsServiceProvider" --tag=config
  php artisan vendor:publish --provider="YlsIdeas\FeatureFlags\FeatureFlagsServiceProvider" --tag=inmemory-config

  composer require mews/captcha
  php artisan vendor:publish --provider="Mews\Captcha\CaptchaServiceProvider" --tag="config"
  composer require yepsua/filament-captcha-field
  
  composer require "spatie/laravel-medialibrary:^10.0.0"
  php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
  php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
  
  composer require magarrent/laravel-currency-formatter
  composer require kodepandai/laravel-api-response  
  
  cd $wd
}

function copyFiles() {
  echo "Copying files..."

  cp -r $skelDir/app $projectDir
  cp -r $skelDir/database $projectDir
  cp -r $skelDir/lang $projectDir
  cp -r $skelDir/resources $projectDir
  cp -r $skelDir/routes $projectDir
  cp -r $skelDir/config/* $projectDir/config
}

function postInstall() {
  cd $projectDir
  php artisan session:table
#   php artisan migrate:fresh --seed
  cd ..
}

function steps() {
  echo "Complete steps"

  echo "Update .env file"
  echo "Set APP_URL=http://localhost:8000"
  read -p "Press enter to continue" ans
  
  echo "Update db credentials in .env file"
  read -p "Press enter to continue" ans

  echo "Set sessions driver to database in .env file"
  read -p "Press enter to continue" ans

#   echo "Run php artisan migrate:fresh --seed"
#   read -p "Press enter to continue" ans

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
  postInstall
  steps
fi
