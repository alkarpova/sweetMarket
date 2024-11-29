<?php

namespace App\Enums;

enum ContactTopic: string
{
    case General = 'general';
    case Support = 'support';
    case Feedback = 'feedback';
    case Other = 'other';
}
