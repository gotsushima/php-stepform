<?php
mb_language('ja');
mb_internal_encoding("UTF-8");
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/POP3.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/language/phpmailer.lang-ja.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 追加処理
$url_param = strstr($_SERVER["REQUEST_URI"], '?');
if (!$url_param) {
  $mail_param = "SEO";
} else {
  $mail_param = $url_param;
}

if (isset($_POST["param"])) {
  $mail_param = $_POST["param"];
}

foreach ($_POST as $key => $val) {
  if (!is_array($val)) {
    $_POST[$key] = mb_convert_kana(htmlspecialchars($val), "KVa");
  }
}

if ($_POST["mode"] == "send") {

  // 完了ページへリダイレクト
  header("Location: complete.php");

  // メール送信先設定
  switch ($_POST["prefecture"]) {
    case '北海道':
    case '青森県':
    case '岩手県':
    case '秋田県':
    case '宮城県':
    case '山形県':
    case '福島県':
    case '茨城県':
    case '栃木県':
    case '群馬県':
    case '埼玉県':
    case '千葉県':
    case '東京都':
    case '神奈川県':
      define("ADMIN_MAIL", "");
      break;
    case '新潟県':
    case '富山県':
    case '石川県':
    case '福井県':
    case '山梨県':
    case '長野県':
    case '岐阜県':
    case '静岡県':
    case '愛知県':
    case '三重県':
      define("ADMIN_MAIL", "");
      break;
    case '滋賀県':
    case '京都府':
    case '兵庫県':
    case '奈良県':
      define("ADMIN_MAIL", "");
      break;
    case '和歌山県':
      define("ADMIN_MAIL", "");
      break;
    case '鳥取県':
    case '島根県':
    case '岡山県':
    case '広島県':
    case '山口県':
    case '徳島県':
    case '香川県':
    case '愛媛県':
    case '高知県':
    case '福岡県':
    case '佐賀県':
    case '長崎県':
    case '熊本県':
    case '大分県':
    case '宮崎県':
    case '鹿児島県':
    case '沖縄県':
      define("ADMIN_MAIL", "");
      break;
    case '大阪府':
      switch ($_POST["city"]) {
        case '豊能郡能勢町':
        case '豊能郡豊能町':
        case '箕面市':
        case '池田市':
        case '豊中市':
        case '吹田市':
        case '茨木市':
        case '摂津市':
        case '高槻市':
        case '三島郡島本町':
        case '守口市':
        case '寝屋川市':
        case '枚方市':
        case '交野市':
        case '門真市':
        case '四條畷市':
        case '大東市':
        case '大阪市西淀川区':
        case '大阪市淀川区':
        case '大阪市東淀川区':
        case '大阪市此花区':
        case '大阪市福島区':
        case '大阪市北区':
        case '大阪市都島区':
        case '大阪市旭区':
        case '大阪市港区':
        case '大阪市西区':
        case '大阪市城東区':
        case '大阪市鶴見区':
          define("ADMIN_MAIL", "");
          break;
        default:
          define("ADMIN_MAIL", "");
      }
      break;
  }

  // メール本文 - 共通部分
  $admin_mail = ADMIN_MAIL;

  $email_content = <<<EOM
＜登録情報＞
【 氏　名 】 {$_POST["name"]}  
【 誕生年 】 {$_POST["birthyear"]}
【都道府県】 {$_POST["prefecture"]}
【 住　所 】 {$_POST["city"]}
【電話番号】 {$_POST["tel"]}
【 メール 】 {$_POST["e-mail"]}


＜ご希望条件＞
【保有資格】 {$_POST["entry_qualifications"]}
【勤務形態】 {$_POST["entry_work_styles"]}
【入職希望】 {$_POST["request_date_id"]}
EOM;

  // メール送信 - お客様へ送信
  $email_text_customer = <<<EOM
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿

■■ ==========　ナヌークワーカー　==========■■

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
{$_POST["name"]}さま、この度はナヌークワーカーに登録のお申し込みを頂きありがとうございます。
    
登録内容の確認メールです。
    
登録内容を確認の上、担当アドバイザーから24時間以内（土日祝を除く）にお電話させていただきます。
    
※専任アドバイザーの携帯電話から連絡する場合もございますので、ご了承ください。

    
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
■今後の流れについて

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
１）{$_POST["name"]}さま専属のアドバイザーが担当につきます。
２）ご希望条件等詳細をお伺いの上、条件に合った求人をご紹介させて頂きます。
３）面接日の設定・条件交渉等を{$_POST["name"]}さまに代わって全て無料でサポートさせて頂きます。
４）面接を受けていただき、双方合意が得られましたら内定・入職となります。
    
給与等の交渉や調整、入社後のフォローまで担当アドバイザーが完全無料で責任を持って対応させて頂きますのでご安心ください。

    
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
■ご登録内容

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
{$email_content}

    
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
■お問い合わせ先

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
登録に関してや、登録後についてのお問い合わせは下記より随時受け付けております。
    
【 電　話 】0120-00-0000


＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
    
ナヌークワーカー

＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿
EOM;

  $mailer = new PHPMailer();
  $mailer->CharSet = 'utf-8';
  $mailer->From = ADMIN_MAIL;
  $mailer->FromName = "ナヌークワーカー";
  $mailer->Subject = "【ナヌークワーカー】仮登録ありがとうございます。";
  $mailer->Body = $email_text_customer;
  $mailer->AddAddress($_POST["e-mail"]);

  if ($mailer->Send()) {
  } else {
    echo "送信に失敗しました" . $mailer->ErrorInfo;
  }

  // メール送信 - 管理者へ送信
  $email_text_admin = <<<EOM
「ナヌークワーカー」登録フォームよりメール送信されました。


{$email_content}


＜登録メディア＞
【媒体】　{$_POST["param"]}
EOM;

  $mailer->ClearAddresses();
  $mailer->Subject = $_POST["name"] . '様からご登録がありました。';
  $mailer->Body = $email_text_admin;
  $mailer->AddAddress(ADMIN_MAIL);

  if ($mailer->Send()) {
  } else {
    echo "送信に失敗しました" . $mailer->ErrorInfo;
  }

  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="robots" content="noindex,nofollow">
  <title>ナヌークワーカー</title>
  <meta name="description" content="">
  <link rel="stylesheet" href="css/destyle.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.0/css/all.css?20221013">
  <link rel="stylesheet" href="css/style.css" />

</head>

<body>
  <div class="fv">
    <img src="img/fv.png" alt="" />
  </div>

  <div class="entry-box">
    <form method="post" name="contact_form">
      <input type="hidden" name="mode" value="send">
      <input type="hidden" name="param" value="<?php echo $mail_param ?>">
      <input type="hidden" name="entry_page_name" value="『ナヌークワーカー』">
      <input type="hidden" name="entry_page_date" value="<?php echo date("Y/m/d"); ?>">

      <!-- ステップ1 -->
      <div id="step1" class="list-step">
        <div class="step-img">
          <img src="img/step-1.png" alt="step1">
        </div>
        <div class="new-arrivals">
          <p><span class="update"></span></p>
          <div class="new-arrivals-box">
            <p>新着求人更新</p>
            <img src="img/icon.png" alt="">
          </div>
        </div>

        <dl class="form-item">
          <dt><span>Q.</span>どの資格をお持ちですか？</dt>

          <dd>
            <ul class="checkbox form-check-btn">
              <li>
                <label>
                  <input type="radio" name="entry_qualifications" value="介護福祉士">
                  <span><img src="img/q1-1.png" alt="介護福祉士">介護福祉士</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_qualifications" value="初任者研修（ヘルパー2級）">
                  <span><img src="img/q1-2.png" alt="初任者研修（ヘルパー2級）">初任者研修<br>（ヘルパー2級）</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_qualifications" value="実務者研修（ヘルパー1級）">
                  <span><img src="img/q1-3.png" alt="実務者研修（ヘルパー1級）">実務者研修<br>（ヘルパー1級）</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_qualifications" value="ケアマネージャー">
                  <span><img src="img/q1-4.png" alt="ケアマネージャー">ケアマネージャー</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_qualifications" value="その他資格あり">
                  <span><img src="img/q1-5.png" alt="その他資格あり">その他資格あり</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_qualifications" value="資格なし">
                  <span><img src="img/q1-6.png" alt="資格なし">資格なし<img src="img/q1-7.png" class="icon" alt="資格なし"></span>
                </label>
              </li>
            </ul>
          </dd>
        </dl>
      </div>
      <!-- ここまで -->

      <!-- ステップ2 -->
      <div id="step2" class="list-step">
        <div class="step-img">
          <img src="img/step-2.png" alt="step2">
        </div>
        <div class="new-arrivals">
          <p><span class="update"></span></p>
          <div class="new-arrivals-box">
            <p>新着求人更新</p>
            <img src="img/icon.png" alt="">
          </div>
        </div>

        <dl class="form-item">
          <dt><span>Q.</span>ご希望の働き方は？</dt>
          <dd>
            <ul class="form-check-btn">
              <li>
                <label>
                  <input type="radio" name="entry_work_styles" value="常勤（夜勤あり）">
                  <span><img src="img/q2-1.png" alt="常勤（夜勤あり）">常勤（夜勤あり）</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_work_styles" value="常勤（夜勤なし）">
                  <span><img src="img/q2-2.png" alt="常勤（夜勤なし）">常勤（夜勤なし）</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_work_styles" value="パート・アルバイト（夜勤あり）">
                  <span><img src="img/q2-3.png" alt="パート・アルバイト（夜勤あり）">パート・アルバイト<br>（夜勤あり）</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_work_styles" value="パート・アルバイト（夜勤なし）">
                  <span><img src="img/q2-4.png" alt="パート・アルバイト（夜勤なし）">パート・アルバイト<br>（夜勤なし）</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_work_styles" value="派遣">
                  <span><img src="img/q2-5.png" alt="派遣">派遣</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="entry_work_styles" value="こだわらない">
                  <span><img src="img/q2-6.png" alt="こだわらない">こだわらない</span>
                </label>
              </li>
            </ul>
          </dd>
        </dl>

        <div class="button-area">
          <button type="button" class="backbtn" id="back2">戻る</button>
        </div>
      </div>
      <!-- ここまで -->

      <!-- ステップ3 -->
      <div id="step3" class="list-step">
        <div class="step-img">
          <img src="img/step-3.png" alt="step3">
        </div>
        <div class="new-arrivals">
          <p><span class="update"></span></p>
          <div class="new-arrivals-box">
            <p>新着求人更新</p>
            <img src="img/icon.png" alt="">
          </div>
        </div>

        <dl class="form-item">
          <dt><span>Q.</span>ご希望の転職時期は？
            <div class="sub">今月は<span class="orange">3か月以内</span>に入職可能な好条件求人が急増しています</div>
          </dt>

          <dd>
            <ul class="form-check-btn">
              <li>
                <label>
                  <input type="radio" name="request_date_id" value="1ヶ月以内">
                  <span><img src="img/q3-1.png" alt="1ヶ月以内">1ヶ月以内</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="request_date_id" value="3ヶ月以内">
                  <span><img src="img/q3-2.png" alt="3ヶ月以内">3ヶ月以内</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="request_date_id" value="6ヶ月以内">
                  <span><img src="img/q3-3.png" alt="6ヶ月以内">6ヶ月以内</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="request_date_id" value="1年以内">
                  <span><img src="img/q3-4.png" alt="1年以内">1年以内</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="request_date_id" value="1年以上先">
                  <span><img src="img/q3-5.png" alt="1年以上先">1年以上先</span>
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="request_date_id" value="良い求人があり次第">
                  <span><img src="img/q3-6.png" alt="良い求人があり次第">良い求人があり次第</span>
                </label>
              </li>
            </ul>
          </dd>
        </dl>

        <div class="button-area">
          <button type="button" class="backbtn" id="back3">戻る</button>
        </div>
      </div>
      <!-- ここまで -->

      <!-- ステップ4 -->
      <div id="step4" class="list-step">
        <div class="step-img">
          <img src="img/step-4.png" alt="step4">
        </div>
        <div class="new-arrivals">
          <p><span class="update"></span></p>
          <div class="new-arrivals-box">
            <p>新着求人更新</p>
            <img src="img/icon.png" alt="">
          </div>
        </div>

        <dl class="form-item">
          <dt><span>Q.</span>現在のおすまいは？
            <div class="small">（周辺の非公開求人をご紹介します）</div>
          </dt>

          <dd>
            <span class="pref-box">
              <span class="select-arrow">
                <select name="prefecture" class="prefecture">
                  <option value="">都道府県選択</option>
                  <option value="北海道">北海道</option>
                  <option value="青森県">青森県</option>
                  <option value="岩手県">岩手県</option>
                  <option value="宮城県">宮城県</option>
                  <option value="秋田県">秋田県</option>
                  <option value="山形県">山形県</option>
                  <option value="福島県">福島県</option>
                  <option value="茨城県">茨城県</option>
                  <option value="栃木県">栃木県</option>
                  <option value="群馬県">群馬県</option>
                  <option value="埼玉県">埼玉県</option>
                  <option value="千葉県">千葉県</option>
                  <option value="東京都">東京都</option>
                  <option value="神奈川県">神奈川県</option>
                  <option value="新潟県">新潟県</option>
                  <option value="富山県">富山県</option>
                  <option value="石川県">石川県</option>
                  <option value="福井県">福井県</option>
                  <option value="山梨県">山梨県</option>
                  <option value="長野県">長野県</option>
                  <option value="岐阜県">岐阜県</option>
                  <option value="静岡県">静岡県</option>
                  <option value="愛知県">愛知県</option>
                  <option value="三重県">三重県</option>
                  <option value="大阪府">大阪府</option>
                  <option value="兵庫県">兵庫県</option>
                  <option value="京都府">京都府</option>
                  <option value="滋賀県">滋賀県</option>
                  <option value="奈良県">奈良県</option>
                  <option value="和歌山県">和歌山県</option>
                  <option value="鳥取県">鳥取県</option>
                  <option value="島根県">島根県</option>
                  <option value="岡山県">岡山県</option>
                  <option value="広島県">広島県</option>
                  <option value="山口県">山口県</option>
                  <option value="徳島県">徳島県</option>
                  <option value="香川県">香川県</option>
                  <option value="愛媛県">愛媛県</option>
                  <option value="高知県">高知県</option>
                  <option value="福岡県">福岡県</option>
                  <option value="佐賀県">佐賀県</option>
                  <option value="長崎県">長崎県</option>
                  <option value="熊本県">熊本県</option>
                  <option value="大分県">大分県</option>
                  <option value="宮崎県">宮崎県</option>
                  <option value="鹿児島県">鹿児島県</option>
                  <option value="沖縄県">沖縄県</option>
                </select>
              </span>
            </span>

            <span class="pref-box">
              <span class="select-arrow">
                <select name="city" class="city">
                  <option value="">選択してください</option>
                </select>
              </span>
            </span>
          </dd>
        </dl>

        <dl class="form-item">
          <dt><span>Q.</span>誕生年は？
            <div class="small">（より正確な給与がわかります）</div>
          </dt>

          <dd>
            <span class="birth-box">
              <span class="select-arrow">
                <select name="birthyear" class="year step4-select">
                  <option value="">選択してください</option>
                  <option value=1946>1946/昭和21</option>
                  <option value=1947>1947/昭和22</option>
                  <option value=1948>1948/昭和23</option>
                  <option value=1949>1949/昭和24</option>
                  <option value=1950>1950/昭和25</option>
                  <option value=1951>1951/昭和26</option>
                  <option value=1952>1952/昭和27</option>
                  <option value=1953>1953/昭和28</option>
                  <option value=1954>1954/昭和29</option>
                  <option value=1955>1955/昭和30</option>
                  <option value=1956>1956/昭和31</option>
                  <option value=1957>1957/昭和32</option>
                  <option value=1958>1958/昭和33</option>
                  <option value=1959>1959/昭和34</option>
                  <option value=1960>1960/昭和35</option>
                  <option value=1961>1961/昭和36</option>
                  <option value=1962>1962/昭和37</option>
                  <option value=1963>1963/昭和38</option>
                  <option value=1964>1964/昭和39</option>
                  <option value=1965>1965/昭和40</option>
                  <option value=1966>1966/昭和41</option>
                  <option value=1967>1967/昭和42</option>
                  <option value=1968>1968/昭和43</option>
                  <option value=1969>1969/昭和44</option>
                  <option value=1970>1970/昭和45</option>
                  <option value=1971>1971/昭和46</option>
                  <option value=1972>1972/昭和47</option>
                  <option value=1973>1973/昭和48</option>
                  <option value=1974>1974/昭和49</option>
                  <option value=1975>1975/昭和50</option>
                  <option value=1976>1976/昭和51</option>
                  <option value=1977>1977/昭和52</option>
                  <option value=1978>1978/昭和53</option>
                  <option value=1979>1979/昭和54</option>
                  <option value=1980>1980/昭和55</option>
                  <option value=1981>1981/昭和56</option>
                  <option value=1982>1982/昭和57</option>
                  <option value=1983>1983/昭和58</option>
                  <option value=1984>1984/昭和59</option>
                  <option value=1985>1985/昭和60</option>
                  <option value=1986>1986/昭和61</option>
                  <option value=1987>1987/昭和62</option>
                  <option value=1988>1988/昭和63</option>
                  <option value=1989>1989/昭和64・平成1</option>
                  <option value=1990>1990/平成02</option>
                  <option value=1991>1991/平成03</option>
                  <option value=1992>1992/平成04</option>
                  <option value=1993>1993/平成05</option>
                  <option value=1994>1994/平成06</option>
                  <option value=1995>1995/平成07</option>
                  <option value=1996>1996/平成08</option>
                  <option value=1997>1997/平成09</option>
                  <option value=1998>1998/平成10</option>
                  <option value=1999>1999/平成11</option>
                  <option value=2000>2000/平成12</option>
                  <option value=2001>2001/平成13</option>
                  <option value=2002>2002/平成14</option>
                  <option value=2003>2003/平成15</option>
                </select>
              </span>
            </span>
          </dd>
        </dl>

        <div class="button-area">
          <button type="button" class="backbtn" id="back4">戻る</button>
        </div>
      </div>
      <!-- ここまで -->

      <!-- ステップ5 -->
      <div id="step5" class="list-step">
        <div class="step-img">
          <img src="img/step-5.png" alt="step5">
        </div>
        <div class="new-arrivals">
          <p><span class="update"></span></p>
          <div class="new-arrivals-box">
            <p>新着求人更新</p>
            <img src="img/icon.png" alt="">
          </div>
        </div>

        <dl class="form-item">
          <dt>お名前
            <div class="small">（現在のお勤め先に知られることはありません）</div>
          </dt>

          <dd>
            <input type="text" name="name" placeholder="">
            <p class="error"></p>
          </dd>
        </dl>


        <dl class="form-item">
          <dt>電話番号
            <div class="small"><span class="marker">（お電話にて非公開求人をお知らせします）</span></div>
          </dt>

          <dd>
            <input type="tel" class="tel" name="tel" placeholder="例）09011112222">
            <p class="error"></p>
          </dd>
        </dl>

        <dl class="form-item">
          <dt class="optional">メールアドレス
            <div class="small">（メールにて非公開求人をお知らせします）</div>
          </dt>

          <dd>
            <input type="text" name="e-mail" placeholder="例）sample@xxx.com">
            <p class="error"></p>
          </dd>
        </dl>

        <input type="hidden" name="ga_client_id">

        <div class="button-area center">
          <p><a href="" target="_blank">利用規約</a>に同意して、</p>
          <button type="submit" class="nextbtn btn-newline" id="next5" onClick="nsfatr('sub');">
            <div class="free">無料</div>
            <div class="btn-text">今すぐ求人を確認する</div>
          </button>
        </div>
        <div class="button-area">
          <button type="button" class="backbtn" id="back5">戻る</button>
        </div>
      </div>
      <!-- ここまで -->
    </form>
  </div>

  <footer>
    <a href="" target="_blank">利用規約</a>｜<a href="" target="_blank">個人情報保護方針</a>｜<a href="" target="_blank">会社概要</a>    
  </footer>

  <script src="js/date.js"></script>
  <script src="js/address.js"></script>
  <script src="js/step.js"></script>
</body>

</html>