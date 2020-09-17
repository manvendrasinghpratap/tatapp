<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Email_template extends Model
{
    protected $primaryKey = 'id_email';
	protected $table = 'email_templates';
}
