<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Send extends REST_Controller {
    function __construct()
    {
        parent::__construct();
    }

    public function sendData_post($long=null,$lat=null,$speed=null,$api)
    {
        $date       = date('d-M-y H:i:s');
        $getDist    = $this->m_main->get("distance");
        $getApi     = $this->m_main->get("auth");
        $getData    = $this->m_main->get("data");
        $params     = array(
                "long_map"      =>$long, 
                "lat_map"       =>$lat, 
                "speed_vehicle" =>$speed, 
                "zoom_map"      =>"18", 
                "created_date"  =>$date
        );
        $api_key = $getApi[0]['api_key_code'];
        $token = trim($api);
        if ($token != $api_key) 
        {
            $this->response([
                "status"    => 0,
                "error"     => "Invalid Api Key"
            ], parent::HTTP_BAD_REQUEST);
        }
        if(($long == null) || ($lat == null) || ($speed == null))
        {
            $this->response([
                "status"    => 0,
                "error"     => "Required"
            ], parent::HTTP_BAD_REQUEST);
        }
        else
        {
            if ($getData == false) 
            {
                $this->m_main->add("data",$params);
                $this->response([
                        "status"        => 1,
                        "msg"           => "DATA_ADDED",
                        "oil_status"    => 0,                    
                ], parent::HTTP_OK);
            }
            else
            {
                $row      = $getData[0];
                $row2     = ( ($getDist == false) ? 0 : $getDist[0]['total_distance'] );
                $lat2     = $row['lat_map'];
                $long2    = $row['long_map'];
                $dist     = $this->_countDistance($lat, $long, $lat2, $long2);
                $measure  = ( ($dist['status'] == true) ? $dist['result'] : 0 );
                $distance = $measure+$row2;
                $this->m_main->delete('distance');
                $this->m_main->add("distance",['total_distance' => $distance,'created_date' => $date]);
                $this->m_main->delete('data');
                $this->m_main->add("data",$params);
                
                if ($row2 >=1500) 
                {
                    $msg = "Sudah waktunya ganti oli...";
                    if($this->sendEmail($msg) != false)
                    {
                        $this->m_main->delete('distance');
                        $this->response([
                            "status"        => 1,
                            "msg"           => "EMAIL_SEND",
                        ], parent::HTTP_CREATED);
                    }
                    else
                    {
                        $this->response([
                            "status"        => 0,
                            "msg"           => "EMAIL_NOT_SEND",
                        ], parent::HTTP_CREATED);                        
                    }
                }
                else
                {
                    $this->response([
                        "status"        => 1,
                        "msg"           => "SUCCESS",
                    ], parent::HTTP_OK);
                }

            }
        }
    }


    private function sendEmail($data)
    {
        $config = [
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'smtp.sendgrid.net',
               'smtp_user' => 'user',    
               'smtp_pass' => 'pass', 
               'smtp_port' => 587,
               'crlf'      => "\r\n",
               'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->from('no-reply@admin.com', 'IOT');
        $row    = $this->m_main->get("login");
        $email  = $row[0];
        $this->email->to($email["login_email"]); //email penerima
        $this->email->subject('Iot | Notification');//subjek email
        $this->email->message($data);//isi email
        if ($this->email->send()) 
        {
            $return =true;
        } 
        else 
        {
            $return =false;
        }

        return $return;
    }

    private function _countDistance($lat1, $lon1, $lat2, $lon2, $unit="K")//kalkulasi jarak tempuh
    {
        $theta      = $lon1 - $lon2;
        $dist       = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist       = acos($dist);
        $dist       = rad2deg($dist);
        $miles      = $dist * 60 * 1.1515;
        $unit       = strtoupper($unit);
        $data       = ($miles * 1.609344);
        $result     = round($data,2);

        if (($lat1 == $lat2) && ($lon1 == $lon2)) 
        {
            $data = array("status" => false, "result" => "Data Sama");
            return $data;
        }
        else
        {    
            $data = array("status" => true, "result" => $result);
            return $data;
        }
    }
}