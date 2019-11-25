<?php


namespace App\Traits;


trait PassDataToObserver
{
    /**
     * Stores event key data
     *
     * @var array
     */
    public $eventData = [];

    /**
     * Fire the given event for the model.
     *
     * @param  string  $event
     * @param  bool    $halt
     * @param  array   $data
     * @return mixed
     */
    protected function fireModelEvent($event, $halt = true, array $data = []) {
        $this->eventData[$event] = $data;
        return parent::fireModelEvent($event, $halt);
    }

    /**
     * Get the event data by event
     *
     * @param  string  $event
     * @return array|NULL
     */
    public function getEventData(string $event) {
        if (array_key_exists($event, $this->eventData)) {
            return $this->eventData[$event];
        }

        return NULL;
    }
}
