<?php


namespace App\Constants;


class ArrayConstant
{
    const ACTIVATION_STATUS = array(
        [
            "value" => "Active",
            "label" => "Active",
        ],
        [
            "value" => "InActive",
            "label" => "InActive",
        ]
    );

    const COMINGSOON_ACTIVATION_STATUS = array(
        [
            "value" => "Active",
            "label" => "Active",
        ],
        [
            "value" => "InActive",
            "label" => "InActive",
        ],
        [
            "value" => "Coming Soon",
            "label" => "Coming Soon",
        ]
    );

    const GENDER_TYPE = array(
        [
            "value" => "Male",
            "label" => "Male",
        ],
        [
            "value" => "Female",
            "label" => "Female",
        ],

    );

    const CONDITION_TYPE =  array(
        [
            "value" => "Yes",
            "label" => "Yes",
        ],
        [
            "value" => "No",
            "label" => "No",
        ],
    );

    const LEVEL = array(
        [
            'value' => 0,
            'label' => 'InActive',
        ],
        [
            'value' => 1,
            'label' => 'Basic',
        ],
        [
            'value' => 2,
            'label' => 'Intermediate',
        ],
        [
            'value' => 3,
            'label' => 'Advanced',
        ],
    );
}
