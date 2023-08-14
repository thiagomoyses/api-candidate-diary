<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    protected $table = "diary";
    protected $fillable = ['candidate_id', 'company_id', 'project_reference', 'status'];

    public function candidate()
    {
        return $this->belongsTo(Candidates::class, 'candidate_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_reference', 'job_reference');
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['candidate_name'] = $this->candidate->name;
        $array['company_name'] = $this->company->name;
        $array['project_title'] = $this->project->title;

        return $array;
    }
}
