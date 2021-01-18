<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Category;

class Video extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'stream_url',
        'source_id',
        'crawl_at',
        'is_hot',
        'status',
        'country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    public $timestamps = true;
    
    public static $youtubeApi = 'https://www.googleapis.com/youtube/v3/';
    
    public static function get_list($params) {
        # Init
        $limit = !empty($params['limit']) ? $params['limit'] : 16;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $offset = ($page - 1)*$limit;

        # Get data
        if (!empty($params['is_random'])) {
            $data = self::inRandomOrder();
        } else {
            $data = self::orderBy('id', 'desc');
        }

        # Filter
        if (isset($params['status']) && $params['status'] != '') {
            $data = $data->where('status', $params['status']);
        }
        if (isset($params['is_hot']) && $params['is_hot'] != '') {
            $data = $data->where('is_hot', $params['is_hot']);
        }
        if (isset($params['country_id']) && $params['country_id'] != '') {
            $data = $data->where('country_id', $params['country_id']);
        }

        # Return data
        $data = $data->offset($offset)->limit($limit)->get();
        return $data;
    }
    
    public static function categories_crawler(){
        $apiKey = config('services.google')['youtube_api_key'];
        $apiUrl = self::$youtubeApi."videoCategories?part=snippet&regionCode=US&key={$apiKey}";
        $res = self::call_api($apiUrl);
        if (!empty($res['items'])) {
            foreach ($res['items'] as $v) {
                $snippet = $v['snippet'];
                $data = [
                    'youtube_id' => $v['id'],
                    'name' => $snippet['title'],
                    'slug' => self::createSlug($snippet['title']),
                    'is_trending' => !empty($snippet['assignable']) ? 1 : 0
                ];
                Category::updateOrCreate([
                    'youtube_id' => $data['youtube_id']
                ], $data);
            }
        }
    }
    
    public static function video_crawler(){
        $data = self::get_youtube_videos();
        echo '<pre>';
        print_r($data);
        die();
        if (!empty($data)) {
            foreach ($data as $v) {
                self::updateOrCreate([
                    'source_id' => $v['source_id']
                ], $v);
            }
        }
    }
    
    /*
     * Youtube channel crawler
     */
    public static function get_youtube_videos($data = [], $nextToken = Null, $skip = False) {
        # Init
        $today = date('Y-m-d', time());
        $categoryId = 19;
        $country = 'VN';
        $apiKey = config('services.google')['youtube_api_key'];
        $apiUrl = self::$youtubeApi."videos?part=snippet,id,contentDetails&chart=mostPopular&key={$apiKey}&maxResults=50&videoCategoryId={$categoryId}&regionCode={$country}";
        if (!empty($nextToken)) {
            $apiUrl .= "&pageToken={$nextToken}";
        }
        
        $res = self::call_api($apiUrl);
        
        return $res;
        if (!empty($res['items'])) {
            foreach ($res['items'] as $v) {
                if ($v['id']['kind'] == 'youtube#video') {
                    $snippet = $v['snippet'];
                    $data[] = [
                        'source_id' => $v['id']['videoId'],
                        'title' => $snippet['title'],
                        'description' => $snippet['description'],
                        'image' => $snippet['thumbnails']['high']['url'],
                        'status' => 1
                    ];
                }
                
            }
            if (!empty($res['nextPageToken']) && $skip == False) {
                $data = self::get_channel_videos($data, $res['nextPageToken']);
            }
        }
        
        return $data;
    }
        
    /*
     * Call Api
     */
    protected static function call_api($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
    
    public static function createSlug($str, $delimiter = '-'){

        $unwanted_array = ['ś'=>'s', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
            'Ś'=>'s', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z']; // Polish letters for example
        $str = strtr( $str, $unwanted_array );

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }

}
