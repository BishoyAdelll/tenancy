<?php

namespace App\Enums;

enum Status  : string
{
        case Booked = "booked";
        case Cancelled = "cancelled";
        case Confirmed = "confirmed";
}

