<?php
//セッションを開始
// session_start();

mb_language("japanese");
mb_internal_encoding("UTF-8");

//送信先アドレスと送信タイトル、送信内容の変数を用意する
// $mail_address = $_SESSION['mail_address']

require("PHPMailer/PHPMailerAutoload.php");
$mailer = new PHPMailer();
$mailer->IsSMTP();
$mailer->Host = 'ssl://smtp.gmail.com:465';
$mailer->SMTPAuth = TRUE;
$mailer->Username = 'louis@tabippo.net';  // Gmailのアカウント名
$mailer->Password = 'ruimaeda4182';  // Gmailのパスワード
$mailer->From     = 'louis@tabippo.net';  // Fromのメールアドレス
$mailer->FromName = mb_encode_mimeheader(mb_convert_encoding("チームFLYHIGH","JIS","UTF-8"));
$mailer->Subject  = mb_encode_mimeheader(mb_convert_encoding("FLYHIGHからのお知らせです","JIS","UTF-8"));
$mailer->Body     = mb_convert_encoding("ここが文字化けする","JIS","UTF-8");
$mailer->AddAddress('ruisu0717@gmai.com'); // 宛先

if( !$mailer->Send() ){
	echo "Message was not sent<br/ >";
	echo "Mailer Error: " . $mailer->ErrorInfo;
} else {
	echo "Message has been sent";
}
?>