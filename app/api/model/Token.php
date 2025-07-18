<?php

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;
use app\api\extends\Random;

class Token extends Model
{

    protected $name = 'user_token';

    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $deleteTime = false;

    protected $autoWriteTimestamp = true;


    /**
     * 生成token
     * @param $user_id
     * @return string
     */
    public function createToken($user_id)
    {
        $this->where('user_id',$user_id)->delete();
        $token                  = Random::uuid();
        $this->user_id          = $user_id;
        $this->token            = $token;
        $this->expire_time      = date('Y-m-d H:i:s',time()+getenv('TOKEN_EXPIRE'));
        $this->save();
        return $token;
        
    }

    /**
     * 关联用户
     * @return \think\model\relation\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')->whereNull('delete_time');
    }
}
