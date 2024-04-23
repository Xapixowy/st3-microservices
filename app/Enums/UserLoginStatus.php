<?php

namespace App\Enums;

enum UserLoginStatus: int
{
    case PASSWORD_INCORRECT = 0;

    case ACCOUNT_NOT_ACTIVATED = 1;

    case ALREADY_LOGGED_IN = 2;

    case NOT_LOGGED_IN = 3;
    case LOGGED_OUT = 4;
}
