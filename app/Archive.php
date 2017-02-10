<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    public static function put($context, $subject, $body)
    {
        $a = new Archive();
        $a->context = $context;
        $a->subject = $subject;
        $a->body = $body;
        $a->save();
    }
}
