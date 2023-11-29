<?php

namespace App\Enums;

enum OAuthService: string
{
    case GoogleAuth = 'google-auth';

    case GoogleCalendar = 'google-calendar';

    case Notion = 'notion';
}
