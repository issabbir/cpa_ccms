<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    protected $table = 'L_SERVICE_TICKET_PRIORITY';
    protected $primarykey = 'TICKET_PRIORITY_NO';
}
