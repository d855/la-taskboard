<?php

    namespace App\Traits;

    use App\Models\Activity;
    use App\Models\Project;
    use Illuminate\Support\Arr;

    trait RecordsActivity
    {

        public array $oldAttributes = [];

        /**
         * Boot the trait.
         */
        public static function bootRecordsActivity()
        {
            foreach (self::recordableEvents() as $event) {
                static::$event(function ($model) use ($event) {
                    $model->recordActivity($model->activityDescription($event));
                });

                if ($event === 'updated') {
                    static::updating(function ($model) {
                        $model->oldAttributes = $model->getOriginal();
                    });
                }
            }
        }

        protected function activityDescription($description)
        {
            return "{$description}_" . strtolower(class_basename($this));
        }

        /**
         * @return array[]
         */
        public static function recordableEvents(): array
        {
            return $recordableEvents = static::$recordableEvents ?? ['created', 'updated', 'deleted'];
        }

        /**
         * Record activity for a project
         *
         * @param string $description
         */
        public function recordActivity(string $description)
        {
            $this->activity()->create([
                'user_id' => $this->activityOwner()->id,
                'description' => $description,
                'changes' => $this->activityChanges(),
                'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id
            ]);
        }

        protected function activityOwner()
        {

            return ($this->project ?? $this)->owner;
        }

        protected function activityChanges()
        {
            if ($this->wasChanged()) {
                return [
                    'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), ['updated_at']),
                    'after' => Arr::except($this->getChanges(), ['updated_at'])
                ];
            }
        }


        /**
         * The activity feed for the project
         *
         * @return \Illuminate\Database\Eloquent\Relations\MorphMany
         */
        public function activity()
        {
            return $this->morphMany(Activity::class, 'subject')->latest();
        }

    }