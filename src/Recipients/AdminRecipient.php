<?php


namespace Combindma\Richcms\Recipients;


class AdminRecipient extends Recipient
{
    public function __construct()
    {
        $this->email = config('app.admin_email');
    }
}
