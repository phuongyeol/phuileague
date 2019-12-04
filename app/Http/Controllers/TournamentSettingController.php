<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TournamentRequest;
use Illuminate\Support\Str;
use App\Tournament;
use App\User;
use Image;
use Log;
use Auth;
use Session;
use Response;
use Validator;
class TournamentSettingController extends Controller
{

    /* 1. View Thông tin chung */ 
    public function setting($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('tournaments.setting', compact('tournament'));
    }
    public function exportChater($slug, $charter){
        // dd(1);
        $pathToFile = public_path('storage/charters/'.$charter);
        
        return Response::make(file_get_contents($pathToFile), 200, [
            'Content-Type'=> 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$charter.'"'
        ]);
    }
    public function updateSetting(Request $request, $slug)
    {   
        $tournament = Tournament::where('slug', $slug)->first();
        $tournaments = Tournament::whereNotNull('slug')->get();
        
        $flag = true;

        if($tournament->name != $request->name){
            foreach($tournaments as $tour){
                if($tour->name == $request->name){
                    $flag = false;
                }
            }
        }
        if($flag == true){
            // Thông tin cơ bản
            $tournament->name = $request->name;
            $tournament->slug = Str::slug($tournament->name,'-');
            $tournament->gender = $request->gender;
            $tournament->stadium = $request->stadium;
            $tournament->address = $request->address;
            // Điểm
            $tournament->score_win = $request->score_win;
            $tournament->score_draw = $request->score_draw;
            $tournament->score_lose = $request->score_lose;
            // Số cầu thủ/ vòng
            if(isset($request->number_player)) $tournament->number_player = $request->number_player;
            if(isset($request->number_round)) $tournament->number_round = $request->number_round;
            if(isset($request->logo)) $tournament->logo = $request->logo;
            if(isset($request->introduce)) $tournament->introduce = $request->introduce;

            $tournament->save();
            // File điều lệ
            if($request->file('charter') != null){
                $file = $request->file('charter');
                $type = $file->getClientMimeType();
                
                if($type == "application/pdf"){
                    $filename = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('storage/charters/'), $filename);
                    $tournament->charter = $filename;
                    $tournament->save();
                    Session::flash('update_tournament', 'Cập nhật thành công!');
                
                }else if($type != "application/pdf"){
                    Session::flash('error_type', 'Định dạng tệp không phải PDF!');
                }
            }else{
                Session::flash('update_tournament', 'Cập nhật thành công!');
            }
        }else{
            Session::flash('name_false', 'Tên giải đã được sử dụng!');
        }
        
        return redirect()->route('tournament.setting', $tournament->slug);
    }

    /* 2. View Trạng thái */ 
    public function status($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();

        return view('settings.status', compact('tournament'));
    }

    public function updateStatus($slug, $status){
        $tournament = Tournament::where('slug', $slug)->first();
        $tournament->status = $status;
        $tournament->save();
        
        Session::flash('update_status', 'Đã thay đổi trạng thái!');

        return response()->json(['status'=>true]);
    }
    /* 3. View quản lý đội bóng */ 
    public function clubs($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.clubs', compact('tournament'));
    }
    /* 4. View sắp xếp bảng đấu */ 
    public function groupstage($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.group_stage', compact('tournament'));
    }
    /* 5. View sắp xếp cặp đấu */ 
    public function matchstage($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.match_stage', compact('tournament'));
    }
    /* 6. iew quản lý lịch đấu */ 
    public function schedule($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.schedule', compact('tournament'));
    }
    /*7.  View Quy tắc xếp hạng */ 
    public function rankingrule($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.ranking_rule', compact('tournament'));
    }
    /* 8. View Nhà tài trợ */ 
    public function supporter($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        return view('settings.supporter', compact('tournament'));
    }
}