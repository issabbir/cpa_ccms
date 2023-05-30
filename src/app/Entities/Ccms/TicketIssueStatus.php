<?php

namespace App\Entities\Ccms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TicketIssueStatus extends Model
{
    protected $table= 'V_TICKET_ISSUE_STATUS';
    public $timestamps = false;
}
