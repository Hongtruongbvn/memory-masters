<?php

namespace App\Helpers;

class StudyHelper
{
    public static function getStudyMethods()
    {
        return [
            'SM2' => [
                'name' => 'SuperMemo SM-2',
                'description' => 'Spaced repetition algorithm for optimal memory retention',
                'default_study_time' => 25,
                'default_break_time' => 5,
                'intervals' => [1, 6, 16, 35, 62],
                'color' => 'blue',
                'icon' => 'fas fa-brain',
            ],
            'Leitner' => [
                'name' => 'Leitner System',
                'description' => 'Box-based system for progressive learning',
                'default_study_time' => 30,
                'default_break_time' => 10,
                'intervals' => [1, 2, 5, 10, 20],
                'color' => 'green',
                'icon' => 'fas fa-layer-group',
            ],
            'Pomodoro' => [
                'name' => 'Pomodoro Technique',
                'description' => 'Time management with focused intervals',
                'default_study_time' => 25,
                'default_break_time' => 5,
                'intervals' => [1, 7, 16],
                'color' => 'red',
                'icon' => 'fas fa-clock',
            ],
            'Custom' => [
                'name' => 'Custom Method',
                'description' => 'Create your own study intervals',
                'default_study_time' => 20,
                'default_break_time' => 5,
                'intervals' => [1, 3, 7, 14, 30],
                'color' => 'purple',
                'icon' => 'fas fa-cog',
            ],
        ];
    }

    public static function getMethodConfig($method)
    {
        $methods = self::getStudyMethods();
        return $methods[$method] ?? $methods['SM2'];
    }
}