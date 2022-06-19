<?php

namespace App\Enums;

enum UserTypes: string
{
    case PROJECT = 'project';
    case COLLECTIVE = 'collective';
    case EVENT = 'event';
    case ORGANIZATION = 'organization';
    case PERSONAL = 'personal';
}
