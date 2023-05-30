<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'L_SERVICE_TICKET_TYPE';
    protected $primarykey = 'TICKET_TYPE_NO';
}
