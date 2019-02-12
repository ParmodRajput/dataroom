<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mail;
use App\Project;
use App\User;

class SetRoomController extends Controller
{
   public function SetupDataRoomByUser(Request $request){
      
       $fullName   = $request->fullName;
       $email      = $request->email; 
       $phone      = $request->phone;
       $company    = $request->company;
       $project    = $request->project; 
       $about_prodata       = $request->about_prodata; 
       $project_type        = $request->project_type ;
       $Project_strat_date  = $request->Project_strat_date ;
       $project_duration    = $request->project_duration ;
       $preferred_payment   = $request->preferred_payment ; 
       $quote_for           = $request->quote_for;
       
       $encryptedFullName = Crypt::encryptString($fullName); 
       $encryptedEmail    = Crypt::encryptString($email); 
       $encryptedPhone    = Crypt::encryptString($phone); 
       $encryptedCompany  = Crypt::encryptString($company); 
       $encryptedProject  = Crypt::encryptString($project); 

       
       $gotoBeforSetRoom = url('/dataroom/User/'.$encryptedFullName.'/'.$encryptedEmail.'/'.$encryptedPhone.'/'.$encryptedCompany.'/'.$encryptedProject);

      
        $data = array(
            'name' => "Invite To Prodata room By prodata.com",
            'full_name'=>  $fullName,
            'email' => $email,
            'phone'   => $phone,
            'company'   => $company,
            'project'  => $project,
            'verifyUrl' => $gotoBeforSetRoom,
            );

            Mail::send('mail.SetDataRoomMail',$data, function ($message) use($email) {
                $message->from('admin@prodata.com', 'Prodata room');
                $message->to($email)->subject('Prodata Team invited you to Trial Data Room
                ')->setBody("url('/')");

            });

           $information = array(
            'name' => "New User registration.",
            'full_name'=>  $fullName,
            'email' => $email,
            'phone'   => $phone,
            'company'   => $company,
            'project'  => $project,
            'about_prodata' => $about_prodata,
            'project_type' => $project_type,
            'Project_strat_date'=> $Project_strat_date,
            'project_duration' => $project_duration,
            'preferred_payment' => $preferred_payment,
            'quote_for'=> $quote_for,
           

            );

            Mail::send('mail.adminInformMail',$information, function ($message){
                $message->from('Prodata@gmail.com', 'Prodata room');
                $message->to('priyanshu.chauhan@contriverz.com')->subject('New user register in prodata room .
                ')->setBody("url('/')");

            });

             return "success";
   }

   public function setDataroomvalidation(Request $request){
        $returnValue = [];
        $enterEmail = $request->enterEmail;
        $enterPhone = $request->enterPhone;

        $check1 = User::where('email',$enterEmail)->pluck('id');

        if (!empty($check1[0])) 
        {
            $returnValue1 = 1;
            array_push($returnValue, $returnValue1);
        }
        else{

            $returnValue1 = 0;
            array_push($returnValue, $returnValue1);
        }
       
       $check2 = User::where('phone_no',$enterPhone)->pluck('id');
       
        if (!empty($check2[0])) 
        {
          $returnValue2 = 1;
          array_push($returnValue, $returnValue2);
        }
        else{
          $returnValue2 = 0;
           array_push($returnValue, $returnValue2);
        } 

        $enterProject = $request->enterProject;
        $projectSlug = str_slug($enterProject, '-');

        $check3 = Project::where('project_slug',$projectSlug)->pluck('id');
       
        if (!empty($check3[0])) 
        {
          $returnValue3 = 1;
           array_push($returnValue, $returnValue3);
        }
        else{
          $returnValue3 = 0;
           array_push($returnValue, $returnValue3);
        } 

        return $returnValue;
      
   }
}
