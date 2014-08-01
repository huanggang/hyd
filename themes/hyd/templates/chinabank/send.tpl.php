<?php
global $user;
global $base_url;

//****************************************
  $v_mid = '1001';                                  // 商户号，这里为测试商户号1001，替换为自己的商户号(老版商户号为4位或5位,新版为8位)即可
  $v_url = $base_url."/api/chinabank_receive";      // 请填写返回url,地址应为绝对路径,带有http协议
  $key   = 'test';                                  // 如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/
                                                    // 登陆后在上面的导航栏里可能找到“资料管理”，在资料管理的二级导航栏里有“MD5密钥设置” 
                                                    // 建议您设置一个16位以上的密钥或更高，密钥最多64位，但设置16位已经足够了
//****************************************

  $bank = trim($_POST['bank']);
  $amount = trim($_POST['amount']);
  $fee = trim($_POST['fee']);

  $v_oid = date('Ymd',time())."-".$v_mid."-".date('His',time());   //订单号，建议构成格式 年月日-商户号-小时分钟秒
   
  $v_amount = $amount + $fee;                                      //支付金额
  $v_moneytype = "CNY";                                            //币种

  $text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;        //md5加密拼凑串,注意顺序不能变
  $v_md5info = strtoupper(md5($text));                             //md5函数加密并转化成大写字母

  $remark1 = strval($user->uid).";".strval($bank);                 //备注字段1
  $remark2 = strval($amount).";".strval($fee);                     //备注字段2

  // for testing only
  // $v_pstatus = "20";
  // $md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));

  drupal_add_js('window.onload = function(){document.E_FORM.submit();}', 'inline');
?>
<div class="pg-loan" id="pg-loan">
  <div class="container_12 mt10">
    <div class="grid_12">
      <div class="loanapp loanapp p20bs color-white-bg">
        <h5>页面跳转，请耐心等待。</h5>

        <!--以下信息为标准的 HTML 格式 + ASP 语言 拼凑而成的 网银在线 支付接口标准演示页面 无需修改-->
        <form method="post" name="E_FORM" action="https://pay3.chinabank.com.cn/PayGate">
          <input type="hidden" name="v_mid"         value="<?php echo $v_mid;?>">
          <input type="hidden" name="v_oid"         value="<?php echo $v_oid;?>">
          <input type="hidden" name="v_amount"      value="<?php echo $v_amount;?>">
          <input type="hidden" name="v_moneytype"   value="<?php echo $v_moneytype;?>">
          <input type="hidden" name="v_url"         value="<?php echo $v_url;?>">
          <input type="hidden" name="v_md5info"     value="<?php echo $v_md5info;?>">
         
          <input type="hidden" name="remark1"       value="<?php echo $remark1;?>">
          <input type="hidden" name="remark2"       value="<?php echo $remark2;?>">

        </form>

        <!-- for testing -->
        <!--form method="post" name="E_FORM" action="<?php echo $v_url; ?>">
          <input type="hidden" name="v_oid"         value="<?php echo $v_oid;?>">
          <input type="hidden" name="v_pmode"       value="借记卡">
          <input type="hidden" name="v_pstatus"     value="<?php echo $v_pstatus;?>">
          <input type="hidden" name="v_pstring"     value="OK">
          <input type="hidden" name="v_amount"      value="<?php echo $v_amount;?>">
          <input type="hidden" name="v_moneytype"   value="<?php echo $v_moneytype;?>">
         
          <input type="hidden" name="remark1"       value="<?php echo $remark1;?>">
          <input type="hidden" name="remark2"       value="<?php echo $remark2;?>">

          <input type="hidden" name="v_md5str"      value="<?php echo $md5string;?>">

        </form-->
      </div>
    </div>
  </div>
</div>
