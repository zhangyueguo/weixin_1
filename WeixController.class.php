<?php
namespace Home\Controller;
use OT\DataDictionary;

use Home\Model\IndexModel;


/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class WeixController extends HomeController {

	//系统首页
    public function weixin(){

      $signature = $_GET['signature'];
      
      $timestamp = $_GET['timestamp'];

      $nonce      = $_GET['nonce'];

      $token  = "weixin";
      
      $tmpArr = array($token,$timestamp,$nonce);

       sort($tmpArr);
       $tmpstr = sha1( $tmpArr );

      if($tmpStr == $signatre && $_GET['echostr']){
            //第一次验证
            echo $_GET['echostr'];exit;
         }else{
            $this->resposry();
         }

        echo "wo zai ceshi";exit;
                 
        $this->display();
    }

   public function resposry()
   {
       //1.接受微信推送过来的消息
      $poststr = $GLOBALS['HTTP_RAW_POST_DATA'];

      $postobj = simplexml_load_string($poststr);

      $indexModel = new IndexModel;

      if($postobj->MsgType=='event')
      {
         if($postobj->Event=='subscribe')
           {
               //回复消息
               $arr = array(
		             array(
				       'title'       =>"济南大学影视传媒o2tv",
					   'description' => "影视作品影视作品影视作品影视作品影视作品影视作品影视作品影视作品影视作品影视作品影视作品",
					   'picur'       => "http://www.o2tv.cn/upload/test/large/14430792696431.png",
					   'url'         => "http://www.o2tv.cn/art.php?id=29",
				   ),
		        );
             //$indexModel->responsubscribemeg($postobj);
             $indexModel->reponseMeg($postobj,$arr);
            // $indexModel->responstextmeg($postobj);
          } 
       }
     
	  if($postobj->MsgType=='text' && $postobj->Content=='tuwen1')
	  {

	  	   $arr = array(
		             array(
				       'title'       =>"o2tv",
					   'description' => "影视作品",
					   'picur'       => "http://www.o2tv.cn/upload/test/large/14430792696431.png",
					   'url'         => "http://www.o2tv.cn/art.php?id=29",
				   ),
				   array(
				       'title'       =>"baidu",
					   'description' => "百度官网",
					   'picur'       => "https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png",
					   'url'         => "www.baidu.com",
				   ),
				   array(
				       'title'       =>"qq",
					   'description' => "qq作品",
					   'picur'       => "http://www.o2tv.cn/upload/test/large/14430792696431.png",
					   'url'         => "www.qq.com",
				   ),
		        );

		   $indexModel->reponseMeg($postobj,$arr);exit;
	  }
	  else
	  { 
	    /*switch($postobj->Content)
          {
               case 1:
                  $content = "我是曰国";
                  break;
               case 2:
                  $content = "世界你好";
                  break;
               case 3:
                  $content = "在做测试";
                  break;
               case 4:
                  $content = "<a href='http://www.baidu.com'>百度</a>";
                  break;
			   default:
                  $content = "谢谢关注我";			  
           }*/

           $arr = $this->tianqi1($postobj);
           $content = "城市:".$arr['retData']['city']."/n天气".$arr['retData']['weather']."/n风向".$arr['retData']['WD']."气温：".$arr['retData']['temp'];
           
	      $indexModel->responstextmeg($postobj,$content);

      } 
   }
   
   public function http_curl()
   {
	   //1.初始化
	   $ch = curl_init();
	   //2.设置参数
	   $url = "www.baidu.com";
	   curl_setopt($ch,CURLOPT_URL,$url);
	   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	   //3.采集
	   $output = curl_exec($ch);
	   //4.关闭
	   curl_close($ch);
	   var_dump($output);
   }
   
   public function getAccessToken()
   {
	   $appid = "wx25477fb4a5fd20d8";
	   $secret = "b9bf8fc1119a4704467aa97278c69d0a";
	   $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
	   //1.初始化
	   $ch = curl_init();
	   curl_setopt($ch,CURLOPT_URL,$url);
	   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	   $res = curl_exec($ch);
	   curl_close($ch);
	   if(curl_errno($ch))
	   {
		   var_dump( curl_errno($ch) );
	   }
	   $arr = json_decode($res,true);
	   //var_dump($arr);
	  // echo $arr['access_token'];exit;
	   return $arr['access_token'];
   }
   
    public function getWxserverIp()
   {
	   $accress = "LNwiNEfwdsWrY93KQt7v-_Hw7KU1kPznAmAVlsx_6buk9fezlZ2gLJKoG0k83vh8ZW_dul8dhDL1256RakxuobYiEodXbNlYZxAdve5pTlpQu100WKFK5q-ZCkXWQFGUOSYhAGABFL";
	   $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accress;
	 
	   
	   $ch = curl_init();
	   curl_setopt($ch,CURLOPT_URL,$url);
	   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	   $res = curl_exec($ch);
	   curl_close($ch);
	   if(curl_errno($ch))
	   {
		   var_dump( curl_errno($ch) );
	   }
	   $arr = json_decode($res,true);
	   echo "<pre>";
	     var_dump($arr);
	   echo "</pre>";
    } 
   
    public function ceshi()
	{
		//echo "wo zai ceshi";exit;
		$indexModel = new IndexModel;
		//var_dump($indexModel);exit;
		$indexModel->ceshi();
	}

	public function tianqi()
	{
		$ak = "01ef8477ae8c264b1fe6fa5aaf1389f8";
        
        $ch = curl_init();
	    $url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.urlencode('北京');
	    $header = array(
	        'apikey: 01ef8477ae8c264b1fe6fa5aaf1389f8',
	    );
	    // 添加apikey到header
	    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // 执行HTTP请求
	    curl_setopt($ch , CURLOPT_URL , $url);
	    $res = curl_exec($ch);
	    return json_decode($res,true);     
   }

   public function tianqi1($postobj)
	{
		$ak = "01ef8477ae8c264b1fe6fa5aaf1389f8";
        
        $ch = curl_init();
	    $url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.urlencode($postobj->Content);
	    $header = array(
	        'apikey: 01ef8477ae8c264b1fe6fa5aaf1389f8',
	    );
	    // 添加apikey到header
	    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // 执行HTTP请求
	    curl_setopt($ch , CURLOPT_URL , $url);
	    $res = curl_exec($ch);
	    return json_decode($res,true);     
   }
   //获取二维码
   public function getQrcode()
   {
	   //1.获取tickt 
	   $access_token = $this->getAccessToken();
	   $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
	   //{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
	   $postarr = array(
	                'expire_seconds' => 604800,//7tian
					'action_name'    => 'QR_SCENE',
					 'action_info'   =>array('scene' => array('scene_id' =>2000,),),
	              );
	    $postjosn = json_encode($postarr);
		
        //方法暂时没写
       //$tickt = $this->http_curlwanneng($url,'post','json',$postjosn); //学习研究一下curl  post请求
	     $this->http_post_curl($url,$postjosn);
	   //2.根据tickt 生成二维码的图片
   }
   public function http_post_curl($url,$data)
   {
	   $ch = curl_init();
	   curl_setopt($ch,CURLOPT_URL,$url);
	   //curl_setopt($ch,CURLOPT_POST,1);
	   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	   curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	   curl_setopt($ch, CURLOPT_HTTPHEADER, array(                   
                          'Content-Type: application/json',  
                          'Content-Length: ' . strlen($data))           
                   );   
       $return = curl_exec ( $ch );
       curl_close ( $ch );
	   var_dump($return);
   }
   


}
