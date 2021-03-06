<?php namespace App\Http\Controllers;

use App\ACME\Helpers\KodiResponse;
use App\Project;
use App\Claim;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller {

    public function getClaims(Request $request)
    {

        if(!$request->has('key')) abort('500','Key not found');

        $user = User::where('apikey','=',$request->input('key'))->first();

        if(is_null($user)) abort('500','User with this key not found');

        $projects = Project::where('client_id','=',$user->id)->get();

        $claims= [];

        foreach($projects as $project)
        {
            $claimCollection = Claim::where('project_id','=',$project->id);
            if($request->has('dts')){
                $dtsObj = new \DateTime($request->input('dts'));
                if(get_class($dtsObj)!=="DateTime") abor(500,'Wrong date format');
                $claimCollection= $claimCollection->where('created_at','>=',$dtsObj->format('Y-m-d H:i:s'));
            }

            if($request->has('dte')){
                $dteObj = new \DateTime($request->input('dte'));
                if(get_class($dteObj)!=="DateTime") abor(500,'Wrong date format');
                $claimCollection= $claimCollection->where('created_at','<=',$dteObj->format('Y-m-d H:i:s'));
            }


            $claimCollection  = $claimCollection->orderBy('created_at',"DESC")->get();
            foreach($claimCollection as $claim)
            {
                $claimEl["id"] = $claim->id;
                $claimEl["project"] = $project->title;
                $claimEl["title"] = $claim->title;
                $claimEl["text"] = $claim->text;
                $claimEl["note"] = $claim->note;
                $claimEl["phone"] = $claim->phone;
                $claimEl["backcall_at"] = $claim->backcall_at;
                $claimEl["created_at"] = $claim->created_at->format('Y-m-d H:i:s');
                $claimEl["statusT"] = $claim->statusT->title;
                $claimEl['properties'] = [];
                foreach(\App\Property::showPropertyValue($claim) as $property){
                    $claimEl['properties'][$property["code"]] = $property['value'];
                }
                $claims[] = $claimEl;
            }
        }
        $response = new KodiResponse();
        return $response->createResponse($claims,200);
    }

}
