<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get countries list
     */
    public function countries(Request $request)
    {
        $countries = [
            ['id' => 1, 'name' => 'United States', 'code' => 'US', 'phone_code' => '+1'],
            ['id' => 2, 'name' => 'Canada', 'code' => 'CA', 'phone_code' => '+1'],
            ['id' => 3, 'name' => 'United Kingdom', 'code' => 'GB', 'phone_code' => '+44'],
            ['id' => 4, 'name' => 'Australia', 'code' => 'AU', 'phone_code' => '+61'],
            ['id' => 5, 'name' => 'Germany', 'code' => 'DE', 'phone_code' => '+49'],
            ['id' => 6, 'name' => 'France', 'code' => 'FR', 'phone_code' => '+33'],
            ['id' => 7, 'name' => 'India', 'code' => 'IN', 'phone_code' => '+91'],
            ['id' => 8, 'name' => 'Japan', 'code' => 'JP', 'phone_code' => '+81'],
            ['id' => 9, 'name' => 'Brazil', 'code' => 'BR', 'phone_code' => '+55'],
            ['id' => 10, 'name' => 'Mexico', 'code' => 'MX', 'phone_code' => '+52'],
        ];

        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }

    /**
     * Get states by country
     */
    public function states($countryId, Request $request)
    {
        $states = [];

        switch ($countryId) {
            case 1: // United States
                $states = [
                    ['id' => 1, 'name' => 'California', 'code' => 'CA'],
                    ['id' => 2, 'name' => 'New York', 'code' => 'NY'],
                    ['id' => 3, 'name' => 'Texas', 'code' => 'TX'],
                    ['id' => 4, 'name' => 'Florida', 'code' => 'FL'],
                    ['id' => 5, 'name' => 'Illinois', 'code' => 'IL'],
                    ['id' => 6, 'name' => 'Pennsylvania', 'code' => 'PA'],
                    ['id' => 7, 'name' => 'Ohio', 'code' => 'OH'],
                    ['id' => 8, 'name' => 'Georgia', 'code' => 'GA'],
                    ['id' => 9, 'name' => 'North Carolina', 'code' => 'NC'],
                    ['id' => 10, 'name' => 'Michigan', 'code' => 'MI'],
                ];
                break;
            case 2: // Canada
                $states = [
                    ['id' => 11, 'name' => 'Ontario', 'code' => 'ON'],
                    ['id' => 12, 'name' => 'Quebec', 'code' => 'QC'],
                    ['id' => 13, 'name' => 'British Columbia', 'code' => 'BC'],
                    ['id' => 14, 'name' => 'Alberta', 'code' => 'AB'],
                    ['id' => 15, 'name' => 'Manitoba', 'code' => 'MB'],
                    ['id' => 16, 'name' => 'Saskatchewan', 'code' => 'SK'],
                ];
                break;
            case 3: // United Kingdom
                $states = [
                    ['id' => 17, 'name' => 'England', 'code' => 'ENG'],
                    ['id' => 18, 'name' => 'Scotland', 'code' => 'SCT'],
                    ['id' => 19, 'name' => 'Wales', 'code' => 'WLS'],
                    ['id' => 20, 'name' => 'Northern Ireland', 'code' => 'NIR'],
                ];
                break;
            case 4: // Australia
                $states = [
                    ['id' => 21, 'name' => 'New South Wales', 'code' => 'NSW'],
                    ['id' => 22, 'name' => 'Victoria', 'code' => 'VIC'],
                    ['id' => 23, 'name' => 'Queensland', 'code' => 'QLD'],
                    ['id' => 24, 'name' => 'Western Australia', 'code' => 'WA'],
                    ['id' => 25, 'name' => 'South Australia', 'code' => 'SA'],
                    ['id' => 26, 'name' => 'Tasmania', 'code' => 'TAS'],
                ];
                break;
            case 7: // India
                $states = [
                    ['id' => 27, 'name' => 'Maharashtra', 'code' => 'MH'],
                    ['id' => 28, 'name' => 'Karnataka', 'code' => 'KA'],
                    ['id' => 29, 'name' => 'Tamil Nadu', 'code' => 'TN'],
                    ['id' => 30, 'name' => 'Gujarat', 'code' => 'GJ'],
                    ['id' => 31, 'name' => 'Rajasthan', 'code' => 'RJ'],
                    ['id' => 32, 'name' => 'Uttar Pradesh', 'code' => 'UP'],
                ];
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $states
        ]);
    }

    /**
     * Get cities by state
     */
    public function cities($stateId, Request $request)
    {
        $cities = [];

        // Sample cities for different states
        switch ($stateId) {
            case 1: // California
                $cities = [
                    ['id' => 1, 'name' => 'Los Angeles'],
                    ['id' => 2, 'name' => 'San Francisco'],
                    ['id' => 3, 'name' => 'San Diego'],
                    ['id' => 4, 'name' => 'Sacramento'],
                    ['id' => 5, 'name' => 'San Jose'],
                ];
                break;
            case 2: // New York
                $cities = [
                    ['id' => 6, 'name' => 'New York City'],
                    ['id' => 7, 'name' => 'Buffalo'],
                    ['id' => 8, 'name' => 'Rochester'],
                    ['id' => 9, 'name' => 'Syracuse'],
                    ['id' => 10, 'name' => 'Albany'],
                ];
                break;
            case 11: // Ontario
                $cities = [
                    ['id' => 11, 'name' => 'Toronto'],
                    ['id' => 12, 'name' => 'Ottawa'],
                    ['id' => 13, 'name' => 'Hamilton'],
                    ['id' => 14, 'name' => 'London'],
                    ['id' => 15, 'name' => 'Windsor'],
                ];
                break;
            case 17: // England
                $cities = [
                    ['id' => 16, 'name' => 'London'],
                    ['id' => 17, 'name' => 'Manchester'],
                    ['id' => 18, 'name' => 'Birmingham'],
                    ['id' => 19, 'name' => 'Liverpool'],
                    ['id' => 20, 'name' => 'Leeds'],
                ];
                break;
            case 21: // New South Wales
                $cities = [
                    ['id' => 21, 'name' => 'Sydney'],
                    ['id' => 22, 'name' => 'Newcastle'],
                    ['id' => 23, 'name' => 'Wollongong'],
                    ['id' => 24, 'name' => 'Central Coast'],
                    ['id' => 25, 'name' => 'Maitland'],
                ];
                break;
            case 27: // Maharashtra
                $cities = [
                    ['id' => 26, 'name' => 'Mumbai'],
                    ['id' => 27, 'name' => 'Pune'],
                    ['id' => 28, 'name' => 'Nagpur'],
                    ['id' => 29, 'name' => 'Nashik'],
                    ['id' => 30, 'name' => 'Aurangabad'],
                ];
                break;
            default:
                $cities = [
                    ['id' => 999, 'name' => 'City 1'],
                    ['id' => 998, 'name' => 'City 2'],
                    ['id' => 997, 'name' => 'City 3'],
                ];
        }

        return response()->json([
            'success' => true,
            'data' => $cities
        ]);
    }
}
