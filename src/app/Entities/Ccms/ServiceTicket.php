<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class ServiceTicket extends Model
{
    protected $table= 'SERVICE_TICKET';
    protected $primaryKey = 'TICKET_NO';

    protected $casts = [
        'meeting_start_time'  => 'datetime:h:i A',
        'meeting_end_time'  => 'datetime:h:i A',
        'occurance_date' => 'date:d-m-Y',
    ];
    //protected $with = ['assigned_service_engineer'];

    public function assigned_service_engineer() {
        return $this->belongsTo(ServiceTicketAssign::class, 'TICKET_NO');
    }

}
