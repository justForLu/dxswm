<?php
namespace App\Http\Controllers\Admin;


use App\Enums\ManagerTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin\RoleUser;
use App\Models\Common\Business;
use Illuminate\Http\Request;
use App\Repositories\Admin\MenuRepository as Menu;
use App\Services\TreeService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Admin\ManagerRepository as Manager;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 登录成功跳转
     * @var string
     */
    protected $redirectTo = '/admin/index';
    /**
     * 退出跳转
     * @var string
     */
    protected $redirectAfterLogout = '/admin/login';

    /**
     * @var
     */
    protected $manager;

    /**
     * @var
     */
    protected $menu;

    protected $log;

    /**
     * LoginController constructor.
     * @param Manager $manager
     * @param Menu $menu
     */
    public function __construct(Manager $manager,Menu $menu, LogRepository $log)
    {
//        $this->middleware('guest')->except('logout');
        $this->manager = $manager;
        $this->menu = $menu;
        $this->log = $log;
    }

    /**
     * 登录视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index()
    {
        return view('admin.login.index');
    }

    /**
     * 自定义guard
     * @return mixed
     */
//    protected function guard()
//    {
//        return Auth::guard('admin');
//    }

    /**
     * 登录校验处理(重写框架默认自带的登录校验)
     *
     * @param LoginRequest $loginRequest
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $loginRequest)
    {
        $this->validateLogin($loginRequest);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($loginRequest)) {
            $this->fireLockoutEvent($loginRequest);

            return $this->sendLockoutResponse($loginRequest);
        }

        if ($this->attemptLogin($loginRequest)) {

            $this->updateLoginInfo($loginRequest);

            session(['managerInfo' => Auth::user()]);

            //店家id
            if(Auth::user()->type == ManagerTypeEnum::BUSINESS){
                $businessInfo = Business::select('id')->where('admin_id',Auth::user()->id)->first();
                session(['business_id' => $businessInfo->id]);
            }

            // 获取用户菜单
            $uid = Auth::user()->id;

            $userMenus = $this->menu->getUserMenuTree();

            // 缓存用户菜单
            Cache::store('file')->forever('menu_user_' . $uid,json_encode($userMenus));
            $this->log->writeOperateLog($loginRequest, '登录后台');
            return response()->json(['status' => 'success','code' => '200','msg' => Lang::get('auth.success'),'referrer' => $this->redirectPath()]);

        }

        return response()->json(['status' => 'fail','code' => '300','msg' => Lang::get('auth.failed')]);

    }

    /**
     * 更新用户的登录信息
     * @param $loginRequest
     */
    public function updateLoginInfo($loginRequest)
    {
        $data['last_ip'] = $loginRequest->ip();
        $data['gmt_last_login'] = get_date();
        $uid = Auth::user()->id;
        $this->manager->update($data,$uid);
    }

    /**
     * 用户登出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * 用户登录用户名
     * @return string
     */
    public function username()
    {
        return 'username';
    }


}
