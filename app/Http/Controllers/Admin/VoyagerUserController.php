<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CommonClass;
use App\Models\Role;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerUserController as BaseVoyagerUserController;

class VoyagerUserController extends BaseVoyagerUserController
{
    public function relation(Request $request)
    {
        if (in_array($request->type, ['user_belongsto_role_relationship', 'user_belongstomany_role_relationship'])) {
            $query = (CommonClass::user()->role_id !=1)?Role::where('id','>', 1):Role::where('id','>', 0);
            if ($request->has('search')) {
                $query->where('display_name', 'LIKE', '%' . $request->search . '%');
            }

            $roles = [
                'pagination'=>['more'=>false],
                'results'=>[
                    ['id'=>'','text'=>'None' ]
                ]
            ];
            foreach ($query->get() as $d){
                $roles['results'][] = [
                    'id'=>$d->id,
                    'text'=>$d->display_name
                ];
            }
            return response()->json($roles);
        }

        return parent::relation($request);
    }


}
