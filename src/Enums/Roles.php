<?php

namespace Combindma\Richcms\Enums;

use BenSampo\Enum\Enum;

final class Roles extends Enum
{
    public const Client = "client";
    public const Manager = "manager";
    public const Editor = "editor";
    public const Admin = "admin";

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Client:
                return 'Client';
            case self::Manager:
                return 'Manager';
            case self::Editor:
                return 'Editeur';
            case self::Admin:
                return 'Administrateur';
            default:
                return parent::getDescription($value);
        }
    }
}
