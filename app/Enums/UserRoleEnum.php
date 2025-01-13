<?php

namespace App\Enums;


enum UserRoleEnum: string
{
    case Admin = 'admin';
    case Agency = 'agency';
    case Viewer = 'viewer';
}
