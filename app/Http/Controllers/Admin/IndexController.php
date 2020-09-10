<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IndexController extends BaseController
{

	public function index()
    {
        return view('admin.index.index');
    }

}
