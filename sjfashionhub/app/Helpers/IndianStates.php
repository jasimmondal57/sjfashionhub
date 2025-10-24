<?php

namespace App\Helpers;

class IndianStates
{
    /**
     * Get all Indian states and union territories
     */
    public static function all()
    {
        return [
            'Andhra Pradesh',
            'Arunachal Pradesh',
            'Assam',
            'Bihar',
            'Chhattisgarh',
            'Goa',
            'Gujarat',
            'Haryana',
            'Himachal Pradesh',
            'Jharkhand',
            'Karnataka',
            'Kerala',
            'Madhya Pradesh',
            'Maharashtra',
            'Manipur',
            'Meghalaya',
            'Mizoram',
            'Nagaland',
            'Odisha',
            'Punjab',
            'Rajasthan',
            'Sikkim',
            'Tamil Nadu',
            'Telangana',
            'Tripura',
            'Uttar Pradesh',
            'Uttarakhand',
            'West Bengal',
            'Andaman and Nicobar Islands',
            'Chandigarh',
            'Dadra and Nagar Haveli and Daman and Diu',
            'Delhi',
            'Jammu and Kashmir',
            'Ladakh',
            'Lakshadweep',
            'Puducherry',
        ];
    }

    /**
     * Get states grouped by region
     */
    public static function byRegion()
    {
        return [
            'North India' => [
                'Delhi',
                'Haryana',
                'Himachal Pradesh',
                'Jammu and Kashmir',
                'Ladakh',
                'Punjab',
                'Rajasthan',
                'Uttar Pradesh',
                'Uttarakhand',
                'Chandigarh',
            ],
            'South India' => [
                'Andhra Pradesh',
                'Karnataka',
                'Kerala',
                'Tamil Nadu',
                'Telangana',
                'Puducherry',
                'Lakshadweep',
                'Andaman and Nicobar Islands',
            ],
            'East India' => [
                'Bihar',
                'Jharkhand',
                'Odisha',
                'West Bengal',
            ],
            'West India' => [
                'Goa',
                'Gujarat',
                'Maharashtra',
                'Dadra and Nagar Haveli and Daman and Diu',
            ],
            'Central India' => [
                'Chhattisgarh',
                'Madhya Pradesh',
            ],
            'Northeast India' => [
                'Arunachal Pradesh',
                'Assam',
                'Manipur',
                'Meghalaya',
                'Mizoram',
                'Nagaland',
                'Sikkim',
                'Tripura',
            ],
        ];
    }

    /**
     * Get state code mapping
     */
    public static function codes()
    {
        return [
            'Andhra Pradesh' => 'AP',
            'Arunachal Pradesh' => 'AR',
            'Assam' => 'AS',
            'Bihar' => 'BR',
            'Chhattisgarh' => 'CG',
            'Goa' => 'GA',
            'Gujarat' => 'GJ',
            'Haryana' => 'HR',
            'Himachal Pradesh' => 'HP',
            'Jharkhand' => 'JH',
            'Karnataka' => 'KA',
            'Kerala' => 'KL',
            'Madhya Pradesh' => 'MP',
            'Maharashtra' => 'MH',
            'Manipur' => 'MN',
            'Meghalaya' => 'ML',
            'Mizoram' => 'MZ',
            'Nagaland' => 'NL',
            'Odisha' => 'OD',
            'Punjab' => 'PB',
            'Rajasthan' => 'RJ',
            'Sikkim' => 'SK',
            'Tamil Nadu' => 'TN',
            'Telangana' => 'TG',
            'Tripura' => 'TR',
            'Uttar Pradesh' => 'UP',
            'Uttarakhand' => 'UK',
            'West Bengal' => 'WB',
            'Andaman and Nicobar Islands' => 'AN',
            'Chandigarh' => 'CH',
            'Dadra and Nagar Haveli and Daman and Diu' => 'DH',
            'Delhi' => 'DL',
            'Jammu and Kashmir' => 'JK',
            'Ladakh' => 'LA',
            'Lakshadweep' => 'LD',
            'Puducherry' => 'PY',
        ];
    }
}

