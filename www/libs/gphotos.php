<?php

  function url_get_contents ($Url) {
    if (!function_exists('curl_init')){
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  }

  class GooglePhotos {

    const RE = '/(?<!=)"https:\/\/lh3\.googleusercontent\.com\/([^\/\[]+?)",[0-9]+?,/';

    public static function albumArray($shareable_link) {
      $str = url_get_contents($shareable_link);
      preg_match_all(self::RE, $str, $matches, PREG_SET_ORDER, 0);
      array_pop($matches);
      $links = array();
      foreach($matches as $match)
      {
        array_push($links,"https://lh3.googleusercontent.com/".$match[1]);
      }
      return $links;
    }
    public static function albumJSON($shareable_link) {
      return json_encode(self::albumArray($shareable_link));
    }

    public static function albumsArray() {
      $albums = func_get_args();
      $links = array();
      foreach($albums as $album){
        $str = url_get_contents($album);
        preg_match_all(self::RE, $str, $matches, PREG_SET_ORDER, 0);
        array_pop($matches);
        foreach($matches as $match)
        {
          array_push($links,"https://lh3.googleusercontent.com/".$match[1]);
        }
      }
      return $links;
    }
    public static function albumsJSON() {
      return json_encode(call_user_func_array("GooglePhotos::albumsArray",func_get_args()));
    }
  }

  //Example using 2 weeks from 2017 converted to JSON
  //GooglePhotos::albumsJSON("https://goo.gl/photos/1FuaFb5m5JjJGh919","https://goo.gl/photos/XYfr2fnv1nqZHDB37");
?>
