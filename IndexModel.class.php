<?php
namespace Home\Model;
use Think\Model;
class IndexModel extends Model
{
	public function reponseMeg($postobj,$arr)
	{
		 $tousername   = $postobj->FromUserName;
           $Fromusername = $postobj->ToUserName;
           $time         = time();
           $msgtype      = 'news';
		   
		   $template     = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<ArticleCount>".count($arr)."</ArticleCount>
							<Articles>";
							foreach($arr as $k=>$v)
							{
							   $template .=	"<item>
											<Title><![CDATA[".$v['title']."]]></Title> 
											<Description><![CDATA[".$v['description']."]]></Description>
											<PicUrl><![CDATA[".$v['picur']."]]></PicUrl>
											<Url><![CDATA[".$v['url']."]]></Url>
											</item>";
								
							}
			$template  .=	"</Articles>
                             </xml>";
							 
			$info = sprintf($template,$tousername,$Fromusername,$time,$msgtype);
            echo $info; 
		  
	}
	/*
	    回复纯文本消息
	 */
    public function responsubscribemeg($postobj)
    {
	      $tousername   = $postobj->FromUserName;
          $Fromusername = $postobj->ToUserName;
          $time         = time();
          $msgtype      = 'text';
          //$content      = '欢迎关注,用户id是'.$tousername.'平台id是'.$Fromusername;
          $content      = '欢迎关注我的微信公众账号';
           $template ="<xml>		
                 <ToUserName><![CDATA[%s]]></ToUserName>
                 <FromUserName><![CDATA[%s]]></FromUserName>
                 <CreateTime>%s</CreateTime>
                 <MsgType><![CDATA[%s]]></MsgType>
                 <Content><![CDATA[%s]]></Content>
                 </xml>";
        $info = sprintf($template,$tousername,$Fromusername,$time,$msgtype,$content);
        echo $info;
    }

    public function responstextmeg($postobj,$content)
    {
    	   $tousername   = $postobj->FromUserName;
           $Fromusername = $postobj->ToUserName;
           $time         = time();
           $msgtype      = 'text';
          // $content      = '我的名字叫曰国';
           $template = "<xml>
                       <ToUserName><![CDATA[%s]]></ToUserName>
                       <FromUserName><![CDATA[%s]]></FromUserName>
                       <CreateTime>%s</CreateTime>
                       <MsgType><![CDATA[%s]]></MsgType>
                       <Content><![CDATA[%s]]></Content>
                       </xml>";
            $info = sprintf($template,$tousername,$Fromusername,$time,$msgtype,$content);
            echo $info;   	  
    }

	public function ceshi()
	{
	   echo " wo zai ce shi";	  
		
	}
}

?>
