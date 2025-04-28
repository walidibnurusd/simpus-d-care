<?php
namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Income;
use App\Models\MarritalStatus;
use App\Models\Service;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\Religion;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Indonesia;

class DependentDropDownController extends Controller
{
    public function provinces()
    {
        return Indonesia::allProvinces();
    }

    public function cities(Request $request, $provinceId)
    {
        $province = Indonesia::findProvince($provinceId, ['cities']);
        if ($province) {
            return response()->json($province->cities->pluck('name', 'id'));
        }
        return response()->json([]);
    }

    public function districts(Request $request, $cityId)
    {
        $city = Indonesia::findCity($cityId, ['districts']);
        if ($city) {
            return response()->json($city->districts->pluck('name', 'id'));
        }
        return response()->json([]);
    }
    public function villages(Request $request, $districtId)
    {
        $district = Indonesia::findDistrict($districtId, ['villages']);
        if ($district) {
            return response()->json($district->villages->pluck('name', 'id'));
        }
        return response()->json([]);
    }

    public function citiesData($id)
    {
        return Indonesia::findProvince($id, ['cities'])->cities;
    }

    public function districtsData($id)
    {
        return Indonesia::findCity($id, ['districts'])->districts;
    }

    public function villagesData($districtId)
    {
        return Indonesia::findDistrict($districtId, ['villages'])->villages;
    }

    public function genderData()
    {
        $genders = Gender::all();
        return $genders;
    }
    public function religionData()
    {
        $religions = Religion::all();
        return $religions;
    }
    public function occupationData()
    {
        $occupations = Occupation::all();
        return $occupations;
    }
    public function educationData()
    {
        $educations = Education::all();
        return $educations;
    }
    public function incomeData()
    {
        $incomes = Income::all();
        return $incomes;
    }
    public function marritalStatusData()
    {
        $statuses = MarritalStatus::all();
        return $statuses;
    }
  
    public function programData()
    {
        $programs = Program::all();
        return $programs;
    }
    public function serviceData()
    {
        $services = Service::all();
        return $services;
    }
    public function employeeData()
    {
        $employee = User::where('role','user')->get();
        return $employee;
    }
  
}
