<?php


namespace Combindma\Richcms\Recipients;


use Illuminate\Notifications\Notifiable;

abstract class Recipient
{
    use Notifiable;

    protected $email;
}
