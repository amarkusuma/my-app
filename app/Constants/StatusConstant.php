<?php


namespace App\Constants;


class StatusConstant
{
    const ACTIVE = 'Active';
    const PENDING = 'Pending';
    const INACTIVE = 'Inactive';
    const APPROVED = 'Approved';
    const REJECTED = 'Rejected';
    const PAID = 'Active';
    const UNPAID = 'Active';
    const SUSPENDED = 'Suspended';
    const EXPIRED = 'Expired';
    const WAITING = 'Waiting';
    const COMPLETED = 'Completed';

    /**
     * CONSTATS FOR STATUS LOCATION
     */
    const COMING_SOON = "Coming Soon";


    /**
     * CONSTATS FOR STATUS RESPONSE JSON
     */
    const SUCCESS = 200;
    const FAILURE = 400;
    const NOT_FOUND = 404;
    const UNAUTHORIZED =  401;

     /**
     * CONSTATS FOR STATUS ROOM BOOKING
     */
    const AVAILABLE = "TERSEDIA";
    const UNAVAILABLE = "TIDAK TERSEDIA";
    
}
