<?php

namespace App\Enums;

enum FlipStep: int
{
    case INPUT_DATA = 1;

    case PAYMENT_METHOD = 2;

    case PAYMENT_CONFIRMATION = 3;
}
