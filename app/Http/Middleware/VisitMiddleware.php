<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;

class VisitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $os = $this->getOs();
        $ip = $this->getIp();
        $browser = $this->getBrowser();
        $lang = $this->getLang();
//        $location = $this->getLocation();
        $location = '-';
        Visit::create([
            'os'=>$os,
            'ip'=>$ip,
            'browser'=>$browser,
            'lang'=>$lang,
            'location'=>$location,
        ]);

        return $next($request);
    }

    private function getOs()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $os = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i', $os)) {
                $os = 'Windows';
            } elseif (preg_match('/mac/i', $os)) {
                $os = 'MAC';
            } elseif (preg_match('/linux/i', $os)) {
                $os = 'Linux';
            } elseif (preg_match('/unix/i', $os)) {
                $os = 'Unix';
            } elseif (preg_match('/bsd/i', $os)) {
                $os = 'BSD';
            } else {
                $os = 'Other';
            }
            return $os;
        } else {
            return "-";
        }
    }

    private function getBrowser()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } elseif (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } elseif (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } elseif (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } elseif (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return "-";
        }
    }

    private function getLang()
    {

        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $lang = substr($lang, 0, 5);
            if (preg_match("/zh-cn/i", $lang)) {
                $lang = "简体中文";
            } elseif (preg_match("/zh/i", $lang)) {
                $lang = "繁体中文";
            } else {
                $lang = "English";
            }
            return $lang;
        } else {
            return "-";
        }
    }

    private function getIp()
    {

        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "-";
        }
        return $ip;
    }

    private function getLocation($ip = '')
    {
        empty($ip) && $ip = $this->getIp();
        if ($ip == "127.0.0.1") return "本机地址";
        $api = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=$ip";   //请求新浪ip地址库
        $json = @file_get_contents($api);
        $arr = json_decode($json, true);
        $country = $arr['country'];
        $province = $arr['province'];
        $city = $arr['city'];
        if ((string)$country == "中国") {
            if ((string)($province) != (string)$city) {
                $_location = $province . $city;
            } else {
                $_location = $country . $city;
            }
        } else {
            $_location = $country;
        }
        return $_location;
    }
}
