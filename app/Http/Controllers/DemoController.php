<?php
namespace App\Http\Controllers;

use App\Models\User;

class DemoController extends Controller
{
    public function index(): mixed
    {
        $users = \DB::table('users')
            ->where('organization_id', 6)
            ->get();

        return $users;
    }
}
