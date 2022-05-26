<?php
/*
Dev @MahmoudM2
*/
$token = "5222706126:AAGJPKzioN7hJHIUvl75lx2lbxvO8kWM8z8";
define('API_KEY',$token);
echo file_get_contents("https://api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
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
$admin = "584023518";
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$id = $message->from->id;
$message = $update->message;
$e_id = $update->callback_query->data->data_id;
$rep = $message->message_id ;
$mid = $message->message_id;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$text = $message->text;
$namee = $update->callback_query->from->first_name;
$user = $message->from->username;
if(isset($update->callback_query)){
  $chat_id = $update->callback_query->message->chat->id;
  $message_id = $update->callback_query->message->message_id;
  $data     = $update->callback_query->data;
 $user = $update->callback_query->from->username;
}
if($message && $from_id != $admin){
bot('forwardMessage',[
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$rep,
'text'=>$text,
]);
}
if($text == "/start"){
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"اختر كيف تريد استخدام اليوتيوب ",
'reply_to_message_id'=>$update->message->message_id,
'parse_mode'=>"MARKDOWN",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'تنزيل صوت', 'callback_data'=>"mp3"],['text'=>'تنزيل فيديو', 'callback_data'=>"mp4"]],
]
])
]);
}
if($data == 'mp3'){
file_put_contents("$chat_id","mp3");
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ارسل الكلمه للبحث عنها وتنزيلها",
'parse_mode'=>"MARKDOWN",
]);
}
if($data == 'mp4'){
file_put_contents("$chat_id","mp4");
bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ارسل الكلمه للبحث عنها وتنزيلها",
'parse_mode'=>"MARKDOWN",
]);
}
$yy = file_get_contents("$chat_id");
if($text && $yy == 'mp3'){
file_put_contents("$chat_id","");
$b = bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"انتظر قليلا ...",
'reply_to_message_id'=>$update->message->message_id,
 ])->result->message_id;
file_get_contents("https://xnxx.fastbots.ml/new-yt.php?text=$text&chat=$chat_id&token=$token&type=mp3&rep=$message_id");
bot('deletemessage',['chat_id'=>$chat_id,'message_id'=>$b]);
sleep(2);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل /start للتحميل مره اخري",
'reply_to_message_id'=>$update->message->message_id,
 ]);
}
if($text && $yy == 'mp4'){
file_put_contents("$chat_id","");
$b = bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"انتظر قليلا ...",
'reply_to_message_id'=>$update->message->message_id,
 ])->result->message_id;
file_get_contents("https://xnxx.fastbots.ml/new-yt.php?text=$text&chat=$chat_id&token=$token&type=mp4&rep=$message_id");
bot('deletemessage',['chat_id'=>$chat_id,'message_id'=>$b]);
sleep(4);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"ارسل /start للتحميل مره اخري",
'reply_to_message_id'=>$update->message->message_id,
 ]);
}
