<?php

    namespace App\Models;

    use App\Traits\RecordsActivity;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Arr;

    class Task extends Model
    {

        use HasFactory, RecordsActivity;

        protected $guarded = [];
        protected $casts = [
            'completed' => 'boolean'
        ];
        protected static array $recordableEvents = ['created', 'deleted'];
        protected $touches = ['project'];

        public function project()
        {
            return $this->belongsTo(Project::class);
        }

        public function path()
        {
            return "/projects/{$this->project->id}/tasks/{$this->id}";
        }

        public function complete()
        {
            $this->update(['completed' => true]);

            $this->recordActivity('completed_task');
        }

        public function incomplete()
        {
            $this->update(['completed' => false]);

            $this->recordActivity('incomplete_task');
        }
    }
