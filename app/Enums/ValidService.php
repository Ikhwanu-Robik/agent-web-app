<?php

namespace App\Enums;

enum ValidService: string
{
    case BUS_TICKET = "bus_ticket";

    case BPJS = "bpjs";

    case POWER = "power";

    case FILM_TICKET = "film_ticket";

    case GAME_TOP_UP = "game_top_up";
}
