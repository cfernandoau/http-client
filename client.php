<?php
class CoreDnaClient
{
    private  $endpoint='https://www.coredna.com/assessment-endpoint.php';
    private  $token = '';

    /**
     * @param $data
     * @return false|string
     * @throws Exception
     */
     function postData($data){
        $opts = array('http' =>
            array(
                'method'  => "POST",
                'header'  => "Content-Type: application/json\r\n".
                             "Authorization: Bearer ".$this->getToken()."\r\n",
                'content' => $this->jsonEncodeData($data),
            )
        );
        return $this->sendRequest($opts);
    }

    /**
     * @return bool|false|string
     * @throws Exception
     */
    function getToken(){
         if($this->token=='') {
             $opts = array('http' =>
                 array(
                     'method' => 'OPTIONS',
                     'header' => "Content-Type: application/json\r\n"
                 )
             );
             return $this->token= $this->sendRequest($opts);
         }else{
             return $this->token;
         }
    }

    /**
     * @param $opts
     * @return false|string
     * @throws Exception
     */
    function sendRequest($opts){
        $context  = stream_context_create($opts);
        $result = file_get_contents($this->endpoint, false, $context);
        if (strpos($http_response_header[0], "4")) {
            $error = 'Request error: '.$http_response_header[0];
                throw new Exception($error);
                die();
            }
        return $result;
    }

    /**
     * @param $data
     * @return false|string
     * @throws Exception
     */
    function jsonEncodeData($data){
        $data=json_encode($data);
        if(json_last_error_msg()=="No error"){
            return $data;
        }else{
            throw new Exception(json_last_error_msg());
            die();
        }
    }
}

$client=new CoreDnaClient();

$data['name'] = "Anton Fernando";
$data['email'] = "cfernando@gmail.com";
$data['url'] = "https://github.com/cfernandoau/http-client";

$client->postData($data);

