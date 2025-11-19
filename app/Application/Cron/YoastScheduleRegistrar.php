<?php

namespace IdealBoresh\Application\Cron;

use IdealBoresh\Contracts\RegistersHooks;

class YoastScheduleRegistrar implements RegistersHooks
{
    public function register(): void
    {
        add_filter('cron_schedules', [$this, 'registerSchedule']);
    }

    public function registerSchedule(array $schedules): array
    {
        $schedules['fifteen_minutes'] = [
            'interval' => 15 * MINUTE_IN_SECONDS,
            'display'  => __('Every 15 Minutes', 'ideal-boresh'),
        ];

        return $schedules;
    }
}
