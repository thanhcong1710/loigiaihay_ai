<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GptAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\UtilityServiceProvider as u;

class GPTController extends Controller
{
    public function list(Request $request)
    {
        $keyword = isset($request->keyword) ? $request->keyword : '';
        $page = isset($request->page) ? (int) $request->page : 1;
        $limit = isset($request->limit) ? (int) $request->limit : 20;
        $offset = $page == 1 ? 0 : $limit * ($page - 1);
        $limitation =  $limit > 0 ? " LIMIT $offset, $limit" : "";
        $cond = " user_id = ".Auth::guard('admin')->user()->id;
        if ($keyword !== '') {
            $cond .= " AND c.question LIKE '%$keyword%'";
        }
        $total = u::first("SELECT count(c.id) AS total FROM chat_gpt AS c WHERE $cond ");
        $list = u::query("SELECT c.*
            FROM chat_gpt AS c WHERE $cond ORDER BY c.id DESC $limitation");
        return view('admin.gpt.list', [
            'list' => $list,
            'total' => $total->total,
            'page' => $page,
            'limit' => $limit,
            'keyword' => $keyword,
            'url'=>route('admin.gpt.list')
        ]);
    }
    public function add(Request $request){
        return view('admin.gpt.add');
    }
    public function store(Request $request){
        $user_coins_info = u::getCoinsByUser(Auth::guard('admin')->user()->id);
        if($user_coins_info->coins_total < $request->coins_tmp){
            return redirect(route('admin.gpt.add'));
        }else{
            $check_init = u::first("SELECT id FROM chat_gpt WHERE code='$request->code' AND created_at>'".date('Y-m-d 00:00:00')."' AND user_id =".Auth::guard('admin')->user()->id);
            if($check_init){
                return redirect(route('admin.gpt.list'));
            }else{
                $chat_id = u::insertSimpleRow(array(
                    'code' => $request->code,
                    'user_id' => Auth::guard('admin')->user()->id,
                    'question' => $request->question,
                    'max_token' => (int)$request->result_token,
                    'coins_tmp' =>  $request->coins_tmp,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'status'=>0
                ),'chat_gpt');
                $params = [
                    'model' => "text-davinci-003",
                    'prompt' => $request->question,
                    'max_tokens' => (int)$request->result_token,
                    'temperature'=> 0
                ];
                $gpt = new GptAPI();
                $data = $gpt->callCompletions($params);
                if(isset($data['choices'][0]['text']) && $data['choices'][0]['text']){
                    $coins = u::getCoinsByToken($data['usage']['total_tokens']);
                    u::updateSimpleRow(array(
                        'answer' => $data['choices'][0]['text'],
                        'total_token' => $data['usage']['total_tokens'],
                        'coins' => $coins,
                        'status' => 1,
                        'meta_data'=>json_encode($data),
                    ),['id'=>$chat_id],'chat_gpt');
                    $data_update_coins =array(
                        'pre_coins' => $user_coins_info->coins,
                        'pre_coins_free'=>$user_coins_info->coins_free,
                        'coins_free' => $user_coins_info->coins_free - $coins > 0 ? $user_coins_info->coins_free - $coins : 0,
                        'coins' => $user_coins_info->coins_free - $coins > 0 ? $user_coins_info->coins : $user_coins_info->coins - ($coins - $user_coins_info->coins_free),
                        'user_id' => Auth::guard('admin')->user()->id,
                        'note' => 'Hỏi đáp GPT',
                        'created_at' =>date('Y-m-d H:i:s'),
                        'data_id' =>$chat_id,
                        'action'=>'CHAT-GPT'
                    );
                    u::insertSimpleRow($data_update_coins,'log_coins');
                    u::updateSimpleRow(array(
                        'coins_free' => $data_update_coins['coins_free'],
                        'coins' => $data_update_coins['coins'],
                    ),array('id'=>Auth::guard('admin')->user()->id),'users');
                }else{
                    u::updateSimpleRow(array(
                        'status' => 2,
                        'meta_data'=>json_encode($data),
                    ),['id'=>$chat_id],'chat_gpt');
                }
            }
            return redirect(route('admin.gpt.detail',['chat_id'=>$chat_id]));
        }
    }
    public function detail(Request $request,$chat_id){
        $chat_info=u::first("SELECT c.*
                FROM chat_gpt AS c
            WHERE c.id=$chat_id");
        return view('admin.gpt.detail',[
            'chat_info'=>$chat_info
        ]);
    }
}
