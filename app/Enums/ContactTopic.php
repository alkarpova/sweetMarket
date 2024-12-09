<?php

namespace App\Enums;

enum ContactTopic: string
{
    case Support = 'support';
    case Feedback = 'feedback';
    case Other = 'other';
}
