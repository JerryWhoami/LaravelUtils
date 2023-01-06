<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BaseObserver
{
  public $modelName = "";
  public $modelKey = "";
  protected $logChannel = "changes";

  public function created(Model $record)
  {
    $this->log('Creo registro', ['id' => $record->id, $this->modelKey => $record->{$this->modelKey}, 'type' => $this->modelName]);
  }

  public function updated(Model $record)
  {
    $this->log('Actualizo registro', ['id' => $record->id, $this->modelKey => $record->{$this->modelKey}, 'type' => $this->modelName]);
  }

  public function deleted(Model $record)
  {
    $this->log('Elimino registro', ['id' => $record->id, $this->modelKey => $record->{$this->modelKey}, 'type' => $this->modelName]);
  }

  public function restored(Model $record)
  {
    //
  }

  public function forceDeleted(Model $record)
  {
    //
  }

  protected function log($message, $context=[], $level="info")
  {
    Log::channel($this->logChannel)->$level($message, $context);
  }
}
