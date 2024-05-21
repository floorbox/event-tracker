<?php

namespace EventTracker\Enums;


enum TrackableEvents: string
{
    case PRODUCT_VISITED = 'product_visited';
    case USER_LOGGED_IN = 'user_logged_in';
    case USER_LOGGED_OUT = 'user_logged_out';
}
