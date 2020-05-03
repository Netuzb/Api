<?php
/* Ushbu kod @UzWebDev tomonidan yozildi 
va Ramazon oyi munosabati bilan bepul tarqatildi.
Barchamizga yaqinlashib kelayotgan Muborak Ramazon oyi qutlug' bo'lsin! Omin 🤲 */

$admin = 605778538'; // Admin ID
$token = '877862432:AAEyCvOkzVlSv3SSF2bK793WjXCmTYvoPNo';  //Bot token

function bot($method,$datas=[]){
global $token;
$url = "https://api.telegram.org/bot".$token."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$mid = $message->message_id;
$data = $update->callback_query->data;
$type = $message->chat->type;
$text = $message->text;
$cid = $message->chat->id;
$uid= $message->from->id;
$name = $message->from->first_name;
$UzWebDev = file_get_contents("data/$from_id/ali.txt");
$to =  file_get_contents("data/$from_id/token.txt");
$url =  file_get_contents("data/$from_id/url.txt");

$key = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Ramazon tabrigi"]],
[['text'=>"Qo`llanma"] ,['text'=>"Reklama berish"]],
]
]);

##@UzWebDev dan Ramazon oyi uchun sovg'a##
if($text=="Qo`llanma"){
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>Ismingiz yozilgan Ramazon tabrigini olish uchun  🕋  Ramazon tabrigi tugmasini bosing va Ismingizni yozib yuboring!</b> \n Bot esa Ismingiz yozilgan Tabriknomani tezda sizga yuboradi!",
'parse_mode'=>'html',
'reply_markup'=>$key
]);
}


$back = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Orqaga qaytish"]],
]
]);

if($type=="private"){
if($text=="/start"){
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>Assalomu Alaykum $name</b>\n\n Ismingiz qatnashgan Ramazon tabrigini ulashuvchi botimizga xush kelibsiz! ",
'parse_mode'=>'html',
'reply_markup'=>$key,
]);
}}

##@UzWebDev dan Ramazon oyi uchun sovg'a##
if($text=="Reklama berish"){
$a=file_get_contents("lichka.txt");
$ab=substr_count($a,"\n");
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>" *REKLAMA RASSILKA* xizmati - sizning reklama postingizga bog'liq bo'ladi.

Botdagi foydalanuvchilar soni:  *$ab*
Xizmat narxi - *kelishiladi*

Xizmatdan foydalanish bo'yicha - adminga yozing: 👉 [ADMIN](tg://user?id=$admin)",
'reply_markup'=>$key,
'parse_mode'=>'markdown',
'disable_web_page_preview'=>true

]);
}
##@UzWebDev dan Ramazon oyi uchun sovg'a##
if($text=="Ramazon tabrigi"){
file_put_contents("data/$from_id/ali.txt", 'to');
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"🕋 <b>Ramazon tabrigida ishtirok etadigan Ismingizni yozib yuboring:</b>

<b>Masalan:</b> Azizbek",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Orqaga qaytish"]],

]
])
]);
}
elseif($UzWebDev == "to"){
$ex=$text;
bot('sendphoto',[
'chat_id'=>$cid,
'photo'=>"https://uzwebnet.altervista.org/api/?name=$ex",
'caption'=>" <b>Ushbu Botdan foydalanganingiz uchun minnatdorman!</b>\n
<i>Alloh Ramazon oyida barchamizga kuch quvvat a`to etsin. </i>",
'parse_mode'=>'HTML',
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Orqaga qaytish"]],
]
])
]);
unlink("data/$from_id/ali.txt");
exit();
}

##@UzWebDev dan Ramazon oyi uchun sovg'a##
if($text=="Orqaga qaytish"){
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>Siz bosh menyudasiz.</b>",
'parse_mode'=>'html',
'reply_markup'=>$key
]);
}

$lichka = file_get_contents("lichka.txt");
mkdir("data");
mkdir("data/$cid");
if($type=="private"){
if(strpos($lichka,"$cid") !==false){
}else{
file_put_contents("lichka.txt","$lichka\n$cid");
}
}
$reply = $message->reply_to_message->text;
$rpl = json_encode([
'resize_keyboard'=>false,
'force_reply' => true,
'selective' => true
]);

##@UzWebDev dan Ramazon oyi uchun sovg'a##
if($text=="/send" and $cid==$admin){
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"Yuboriladigan xabar matnini kiriting!",'parse_mode'=>"html",'reply_markup'=>$rpl
]);
}
if($reply=="Yuboriladigan xabar matnini kiriting!"){
$lich = file_get_contents("lichka.txt");
$lichka = explode("\n",$lich);
foreach($lichka as $uid){
bot("sendmessage",[
'chat_id'=>$uid,
'text'=>"$text"]);
}
}
if($text=="/stat" and $cid==$admin){
$lich = substr_count($lichka,"\n");
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"Bot foydalanuvchilari soni $lich ta.",
'parse_mode'=>"html"
]);
}

?>
