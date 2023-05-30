<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;


class ServiceEngineerInfoList extends Model
{
    protected $table= 'SERVICE_ENGINEER_INFO';
    protected $primaryKey = 'SERVICE_ENGINEER_INFO_ID';

    protected $with = ['skills','ticket_status'];
    public function skills() {
        return $this->belongsToMany(EngineerSkill::class, 'service_engineer_skill_mapping','SERVICE_ENGINEER_ID','SERVICE_SKILL_ID');
    }
    public function ticket_status(){
        return $this->belongsTo(EngineerTicketStatus::class,'service_engineer_id','service_engineer_id');
    }
}



