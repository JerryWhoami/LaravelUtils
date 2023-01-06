#!/bin/bash

skelDir="/home/jack/Dev/Projects/Filament/skel/"

function install() {
  echo "Installing..."
  
  composer require livewire/livewire
  php artisan livewire:publish --config
  
  composer require filament/filament:"^2.0"
  php artisan vendor:publish --tag=filament-config
  php artisan vendor:publish --tag=filament-translations
  php artisan vendor:publish --tag=filament-forms-translations
  php artisan vendor:publish --tag=filament-tables-translations
  php artisan vendor:publish --tag=filament-support-translations

  composer require filament/spatie-laravel-media-library-plugin:"^2.0"

  composer require invaders-xx/filament-jsoneditor
  php artisan vendor:publish --tag=filament-jsoneditor-img

  npm install
  npm install tailwindcss @tailwindcss/forms @tailwindcss/typography autoprefixer tippy.js --save-dev
  npx tailwindcss init
  
  npm install @fullcalendar/core @fullcalendar/interaction @fullcalendar/daygrid @fullcalendar/timegrid @fullcalendar/list @fullcalendar/scrollgrid @fullcalendar/bootstrap5 
}

function copyFiles() {
  echo "Copying files..."

  cp $skelDir/Filament/Models/* $projectDir/app/Models
  cp $skelDir/Filament/Provider/* $projectDir/app/Providers
}


function steps() {
  echo "Complete steps"

  echo "Uncomment Filament::serving block starting at line 22 in file app/Providers/AppServiceProvider"
  read -p "Press enter to continue" ans

#   echo "Run php artisan migrate:fresh --seed"
#   read -p "Press enter to continue" ans

  echo "Start server"
}

install

if [ "$?" == "0" ]; then
  copyFiles
  steps
fi
