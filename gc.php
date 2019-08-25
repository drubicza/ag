<?php
include "curl.php";

function fn_reg($s_ref,$s_key)
{
    $c_res = curl($s_ref);
    preg_match("/Redirecting to (.+)/",$c_res,$s_re1);
    echo "\n[#] Url Direct\n";

    if ($c_res) {
        $c_res2 = curl($s_re1[1]);
        $c_cook = getcookies($c_res2);
        echo "[*] Ambil Cookies\n";
        $c_res3 = curl("https://fakenametool.net/random-name-generator/random/en_AU/australia/1");
        preg_match("/<span>(.*?)<\/span>/",$c_res3,$s_re2);
        $s_mail = strtolower(str_replace(" ","",$s_re2[1]))."@gmail.com";

        if ($c_cook != "") {
            echo "[!] Berhasil mendapatkan Cookie\n";
            $a_head = array(
                      "Authority: auth.globalcurrencyunit.io",
                      "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36 OPR/62.0.3331.116",
                      "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.",
                      "Content-Type: application/x-www-form-urlencoded",
                      "Cookie: __cfduid=".$c_cook["__cfduid"]."; connect.sid=".$c_cook["connect_sid"]."; referrer=".$c_cook["referrer"]."; _csrf=ZlCr3DF7M8wXIQMyJyKGCbbW;",);
            $c_res4 = curl("https://auth.globalcurrencyunit.io/registration",null,$a_head);
            preg_match("/<input type="hidden" name="_csrf" value="(.*?)">/",$c_res4,$s_re3);

            if ($s_re3 != "") {
                echo "[*] Mencoba mendaftar\n";
                $c_res5 = curl("https://auth.globalcurrencyunit.io/registration","_csrf=".$s_re3[1]."&email=".$s_mail."&password=Nabila123@&password_confirmation=Nabila123@",$a_head);

                if (stripos($c_res5,"Location: /api/v1/login/pipeline")) {
                    echo"[!] Daftar sukses $s_mail | Nabila123@\n";
                    $c_res6 = curl("https://auth.globalcurrencyunit.io/api/v1/login/pipeline","_csrf=".$s_re3[1]."&email=".$s_mail."&password=Nabila123@&password_confirmation=Nabila123@",$a_head);
                    preg_match("/<form action="(.*?)" method="POST" id="redirect">/",$c_res6,$s_re4);
                    preg_match("/ <input type="hidden" name="token" value="(.*?)">/",$c_res6,$s_re5);
                    echo "[*] Mencoba masuk\n";

                    if (stripos($c_res6,"redirecting")) {
                        $c_res7 = curl($s_re4[1],"token=".$s_re5[1]);
                        echo "[!] Berhasil Masuk\n";
                    } else {
                        echo "[!] Gagal untuk masuk\n";
                    }
                } else {
                    echo "[!] Gagal mendaftar\n";
                }
            } else {
                echo "[!]  Ada yang salah\n";
            }
        } else {
            echo "[!]  Sesuatu yang salah\n";
        }
    }
}

function fn_main()
{
    print("Global Currency Unit Referral\n");
    print("Thanks : Yudha Tira Pamungkas, Muhammad Ikhsan Aprilyadi\n\n");

    echo "Url Reff: ";
    $s_ref = trim(fgets(STDIN));

    echo "Key : ";
    $s_key = trim(fgets(STDIN));

    if ($s_key == "Nabilah") for($i = 0; $i < 10; $i++) { fn_reg($s_ref,$s_key); }
}

fn_main();

while (true) {
    echo "\nApakah Ingin mencoba lagi? (y/n): ";
    $s_ask = trim(fgets(STDIN));

    if ($s_ask == "y") {
        echo "\n";
        fn_main();
    } else {
        die("Fuck mantan\n");
    }
}
?>
