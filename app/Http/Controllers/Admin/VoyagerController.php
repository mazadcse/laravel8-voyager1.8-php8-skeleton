<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonClass;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerController as BaseVoyagerController;

class VoyagerController extends BaseVoyagerController
{
    public function index()
    {
        $summery = [

        ];

        $sevenDaysBusiness = [
            'title' => 'Business in Seven days',
            "topics"=>["Sep-18", "Sep-19", "Sep-20", "Sep-21", "Sep-22", "Sep-23", "Sep-24"],
            'datasets'=>[
                [
                    'label'=> "Sales Total",
                    'data'=> [500,1000,2000,1500,1000,2000,3000],
                    'borderColor'=> "green",
                    'backgroundColor'=> "green",
                    'color'=> "green",
                    'fill'=> false,
                ],
                [
                    'label'=> "Sales Paid",
                    'data'=> [300,800,1500,1500,700,1800,2600],
                    'borderColor'=> "blue",
                    'backgroundColor'=> "blue",
                    'color'=> "blue",
                    'fill'=> false,
                ],
                [
                    'label'=> "Sales Due",
                    'data'=> [200,200,500,0,300,200,400],
                    'borderColor'=> "red",
                    'backgroundColor'=> "red",
                    'color'=> "red",
                    'fill'=> false,
                ],
                [
                    'label'=> "Purchase Total",
                    'data'=> [1000, 2000, 0, 0, 2000, 1000, 0],
                    'borderColor'=> "orange",
                    'backgroundColor'=> "orange",
                    'color'=> "orange",
                    'fill'=> false,
                    'borderDash'=> [5, 5],
                ],
                [
                    'label'=> "Purchase Paid",
                    'data'=> [200, 2800, 0, 1330, 1000, 0, 0],
                    'borderColor'=> "brown",
                    'backgroundColor'=> "brown",
                    'color'=> "brown",
                    'fill'=> false,
                    'borderDash'=> [5, 5],
                ],
                [
                    'label'=> "Purchase Due",
                    'data'=> [800, 0, 1110, 1000, 0, 1000, 1000],
                    'borderColor'=> "pink",
                    'backgroundColor'=> "pink",
                    'color'=> "pink",
                    'fill'=> false,
                    'borderDash'=> [5, 5],
                ],
            ]
        ];

        $monthlySales = [
            "title"=>"Monthly Sales of 2022",
            "topics"=>['Jan', 'Fev', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            "colors"=> ["red", "green","blue","orange","brown", "yellow", "red", "green","blue","orange","brown", "yellow" ],
            "values"=>[55, 49, 44, 24, 15,15,15,15,12,0,0,0,]
        ];

        $salesAccountInfo = [
            "title"=>"Sales information",
            "topics"=>["Paid", "Due", "Return"],
            "colors"=> [ "#178a86","#f78534","plum"],
            "values"=>[55, 49, 15]
        ];

        $purchaseAccountInfo = [
            "title"=>"Purchase information",
            "topics"=>["Paid", "Due", "Return"],
            "colors"=> [ "#178a86","#f78534","plum"],
            "values"=>[55, 49, 15]
        ];

        return Voyager::view('voyager::index',[
            'summery'=>$summery,
        ]);

//        return parent::index(); // TODO: Change the autogenerated stub
    }
}
