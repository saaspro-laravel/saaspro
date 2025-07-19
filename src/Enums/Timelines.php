<?php

namespace SaasPro\Enums;

enum Timelines:string {

    case SECOND = 'SECOND';
    case MINUTE = 'MINUTE';
    case HOUR = 'HOUR';
    case DAY = 'DAY';
    case WEEK = 'WEEK';
    case MONTH = 'MONTH';
    case YEAR = 'YEAR';

    function days() {
        return match($this) {
            // self::SECOND => 86400,
            // self::MINUTE => 1440,
            // self::HOUR => 24,
            self::DAY => 1,
            self::WEEK => 7,
            self::MONTH => 30,
            self::YEAR => 360
        };
    }
    
    function label(){
        return match($this) {
            self::SECOND => 'Every Second',
            self::MINUTE => 'Every Minute',
            self::HOUR => 'Hourly',
            self::DAY => 'Daily',
            self::WEEK => 'Weekly',
            self::MONTH => 'Monthly',
            self::YEAR => 'Yearly'
        };
    }
    
    static function options(){
        return [
            self::DAY->value => self::DAY->label(),
            self::WEEK->value => self::WEEK->label(),
            self::MONTH->value => self::MONTH->label(),
            self::YEAR->value => self::YEAR->label()
        ];
    }

    function interval($count = 1){
        return $this->days() * $count;
    }

}