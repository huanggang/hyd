<?php
// 1: matched; 0: unmatched; -1: notice administrator for the error
fuction verify_id($name, $ssn)
{

  $flag = -1;
  $error_msg = '';

  try 
  {
    //ini_set( "soap.wsdl_cache_enabled", "0" );
    //ini_set( "soap.wsdl_cache_ttl", "0" );

    $client = new SoapClient("https://api.nciic.com.cn/nciic_ws/services/NciicServices?wsdl", array(
                                                  'location' => "https://api.nciic.com.cn/nciic_ws/services/NciicServices",
                                               'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP, 
                                                  'encoding' => 'UTF-8',
                                                     'trace' => 1,
                                                'exceptions' => 0,
                                        'connection_timeout' => 2000));

    $licensecode = file_get_contents("授权文件_清远市好易货网络财务有限公司_qyhy.txt");

    $condition = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><ROWS><INFO><SBM>清远市好易货网络财务有限公司</SBM></INFO><ROW><GMSFHM>公民身份号码</GMSFHM><XM>姓名</XM></ROW><ROW FSD=\"清远\" YWLX=\"好易货身份认证\"><GMSFHM>" . $ssn . "</GMSFHM><XM>" . $name . "</XM></ROW></ROWS>";

    $parm = array('inLicense' => $licensecode, 'inConditions' => $condition);
    $result = $client->nciicCheck($parm);
    $result = get_object_vars($result); //将stdclass object转换为array,这个比较重要了
    
    //var_dump($result);
    /*
    $file = fopen("result.txt", "w");
    echo fwrite($file, $result['out']);
    fclose($file);
    */

    $out = $result['out'];

    $dom = new DOMDocument();
    $dom->loadXML($out);

    $rows = $dom->getElementsByTagName("ROW");

    foreach($rows as $row) // make sure only submit one row each time
    {
      $gmsfhm = $row->getElementsByTagName("result_gmsfhm");
      if ($gmsfhm->length == 0)
      {
        $error = $row->getElementsByTagName("errormesage");
        if ($error->length > 0)
        {
          $flag = 0;
          $error_msg = $error->item(0)->nodeValue;
        }
        $errorcol = $row->getElementsByTagName("errormesagecol");
        if ($errorcol->length > 0)
        {
          $flag = 0;
          $error_msg = $error_msg . "; " . $errorcol->item(0)->nodeValue;
        }

        if ($flag == -1)
        {
          $errorcode = $row->getElementsByTagName("ErrorCode");
          if ($errorcode->length > 0)
          {
            $error_msg = $errorcode->item(0)->nodeValue;
          }
          $errormessage = $row->getElementsByTagName("ErrorMsg");
          if ($errormessage->length > 0)
          {
            $error_msg = $error_msg . "; " . $errormessage->item(0)->nodeValue;
          }
        }
      }
      else
      {
        $result_gmsfhm = $gmsfhm->item(0)->nodeValue;
        $xm = $row->getElementsByTagName("result_xm");
        if ($xm->length > 0)
        {
          $result_xm = $xm->item(0)->nodeValue;
          $flag = $result_gmsfhm == "一致" && $result_xm == "一致" ? 1 : 0;
        }
      }
    }
  }
  catch (SoapFault $exception)
  {
    $error_msg = $exception->getMessage();
  }

  if ($flag == -1)
  {
    $file = fopen("error_verify_id.log", "a");
    fwrite($file, "\r\n" . $error_msg);
    fclose($file);
  }
  return $flag;
}
?>
