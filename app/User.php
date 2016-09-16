<?php
namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hashids\Hashids;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param $data User data sent from middleware
     * @return static
     */
    public static function existsUser($data)
    {
        // TODO: set a salt
        $token = session('fb_user_access_token');
        $user = self::where('facebook_user_id', $data->id)->first();
        if (!count($user)) {
            $new_user = (array)$data;
            $new_user['facebook_user_id'] = $new_user['id'];
            $new_user['access_token'] = $token;
            $hashids = new Hashids(time(), 15);  // generate a referral code
            $referral = $hashids->encode(time());
            $new_user['referral'] = $referral;
            $new_user = array_except($new_user, ['id']);
            $user = self::create($new_user);
        }
        else {
            $user->fill(['access_token' => $token])->save();
        }
        return $user;
    }

    public static function isNotCreated($fb_id) {
        $user = self::where('facebook_user_id', $fb_id)->count();

        return $user == 0;
    }

    public function comparisons()
    {
        return $this->hasMany('\App\Comparison', 'user_id', 'id');
    }

    public function blastings()
    {
        return $this->hasMany('\App\Blasting', 'user_id', 'id');
    }
}
