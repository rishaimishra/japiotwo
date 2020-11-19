<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\Helpers\DataFormatterHelpers;
class DataFormatController extends Controller
{
    public function __construct()
    {
         $page_data = ['menu_selected'=>'connection','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }

    public function testDataFormat($dataset_id){
        $formattedData = DataFormatterHelpers::format($dataset_id);
        dd($formattedData);
        
    }

    

}
