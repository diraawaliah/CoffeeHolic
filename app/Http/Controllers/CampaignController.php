<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Menu;

class CampaignController extends Controller
{
    public function index()
    {
        $campaignMenus = \App\Models\Menu::where('name', 'like', '%Goguma%')->get();
        
        return view('campaign', compact('campaignMenus'));
    }
}