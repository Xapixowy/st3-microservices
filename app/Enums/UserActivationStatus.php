<?php

namespace App\Enums;

enum UserActivationStatus: int
{
    case NOT_ACTIVATED = 0;
    case ACTIVATED = 1;
    case ALREADY_ACTIVATED = 2;
}
