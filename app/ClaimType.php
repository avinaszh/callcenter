<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ClaimType extends Model {

    protected $fillable=[
        'project_id',
        'title',
        'price',
        'sort',
        'send_mail'
    ];

}
