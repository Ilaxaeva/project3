<?php
include 'config.php';


if (isset($_GET['dbasket'])) {

    $p_delete = $db->prepare('DELETE from basket where product=' . $_GET['dbasket'] . '');
    $p_delete->execute();




    header('location:../basket.php');
}
// ADMİN GİRSİNİN YOXLANMASİ
if (isset($_POST['mail'])) {

    $pass_check = $db->prepare('SELECT * from admin where  mail=:mail and pass=:pass');
    $pass_check->execute(
        array(
            "mail" => $_POST['mail'],
            "pass" => md5($_POST['pass'])
        )
    );

    $pass_scan = $pass_check->rowCount();


    if ($pass_scan == 1) {
        header('location:../index.php');
        setcookie('adminlogin', md5($_POST['pass']), strtotime('+1 day'), "/");
    } else {
        header('location:../index.php?login=no');
    }



}



// MEHSULUN ELAVE EDİLMESİ


if (isset($_FILES['product_img'])) {

    // TİPİN YOXLANMASİ
    if ($_FILES['product_img']['type'] == "image/png" || $_FILES['product_img']['type'] == "image/jpg" || $_FILES['product_img']['type'] == "image/jpeg" || $_FILES['product_img']['type'] == "image/webp") {

        // Olcunun yoxlanmasi 1 Mbit

        if ($_FILES['product_img']['size'] < 1048576) {

            $yuklenecek_adres = '../assets/' . md5(uniqid(rand())) . "." . substr($_FILES['product_img']['type'], 6, 20);





            if (move_uploaded_file($_FILES['product_img']['tmp_name'], $yuklenecek_adres)) {


                $add_user = $db->prepare('INSERT into product set
 name=:name,
 sale=:sale,
 price=:price,
 count=:count,
 discount=:discount,
 img=:img,
 detail=:detail
 ');
                $add_user->execute(
                    array(
                        'name' => strip_tags($_POST['product_name']),
                        'sale' => strip_tags($_POST['product_sale']),
                        'count' => strip_tags($_POST['product_count']),
                        'discount' => strip_tags($_POST['product_discount']),
                        'price' => strip_tags($_POST['product_price']),
                        'detail' => strip_tags($_POST['product_detail']),
                        'img' => $yuklenecek_adres
                    )
                );

                header("location:../index.php");

            } else {
                echo "Yuklenme zamani xeta bas verdi";
            }










        } else {
            echo "Fayl hecmi maksimum 1mbit olmaldir !";
        }


    } else {
        echo "Fayl tipi duzgu deyil";
    }



}


// MEHSULUN SİLİNMESİ

if (isset($_GET['p_delete'])) {

    $p_delete = $db->prepare('DELETE from product where id=:id');
    $p_delete->execute(
        array(

            'id' => $_GET['p_delete']

        )
    );

    header('location:../list_product.php?delete=ok');


}


// MEHSUL EDİT 



if (isset($_POST['product_name_edit'])) {

    if ($_POST['img_type'] == 0) {


        $p_edit = $db->prepare("UPDATE  product set 
name=:name,
price=:price,
count=:count,
discount=:discount,
sale=:sale,
detail=:detail
where id=:id
");

        $p_edit->execute(
            array(

                'name' => $_POST['product_name_edit'],
                'price' => $_POST['product_price_edit'],
                'count' => $_POST['product_price_count'],
                'discount' => $_POST['product_price_discount'],
                'sale' => $_POST['product_sale_edit'],
                'detail' => $_POST['product_detail_edit'],
                'id' => $_POST['edit_id']

            )
        );

        header('location:../add_product.php?id=' . $_POST['edit_id']);

















    } else {







        // TİPİN YOXLANMASİ
        if ($_FILES['product_img_edit']['type'] == "image/png" || $_FILES['product_img_edit']['type'] == "image/jpg" || $_FILES['product_img_edit']['type'] == "image/jpeg" || $_FILES['product_img_edit']['type'] == "image/webp") {

            // Olcunun yoxlanmasi 1 Mbit

            if ($_FILES['product_img_edit']['size'] < 1048576) {

                $yuklenecek_adres = '../assets/' . md5(uniqid(rand())) . "." . substr($_FILES['product_img_edit']['type'], 6, 20);





                if (move_uploaded_file($_FILES['product_img_edit']['tmp_name'], $yuklenecek_adres)) {


                    $p_edit = $db->prepare("UPDATE  product set 
        name=:name,
        price=:price,
        sale=:sale,
        count=:count,
discount=:discount,
        img=:img,
        detail=:detail
        where id=:id
        ");
                    $p_edit->execute(
                        array(
                            'name' => $_POST['product_name_edit'],
                            'price' => $_POST['product_price_edit'],
                            'sale' => $_POST['product_sale_edit'],
                            'count' => $_POST['product_price_count'],
                            'discount' => $_POST['product_price_discount'],
                            'detail' => $_POST['product_detail_edit'],
                            'id' => $_POST['edit_id'],
                            'img' => $yuklenecek_adres
                        )
                    );

                    header('location:../add_product.php?id=' . $_POST['edit_id']);


                } else {
                    echo "Yuklenme zamani xeta bas verdi";
                }










            } else {
                echo "Fayl hecmi maksimum 1mbit olmaldir !";
            }


        } else {
            echo "Fayl tipi duzgu deyil";
        }













    }

}


if (isset($_POST['product_id'])) {


    $product_check = $db->prepare('SELECT * FROM basket where cookie=:cookie and product=:product');
    $product_check->execute(
        array(
            'cookie' => $_COOKIE['userlogin'],
            'product' => $_POST['product_id']
        )
    );

    $product_count = $product_check->rowCount();

    if ($product_count == 0) {
        $add_basket = $db->prepare('INSERT into basket set
cookie=:cookie,
product=:product,
product_count=:product_count
    ');
        $add_basket->execute(
            array(
                "cookie" => $_COOKIE['userlogin'],
                'product' => $_POST['product_id'],
                'product_count' => 1

            )
        );

        header('location:../index.php');

    } else {
        $product_update = $db->prepare("UPDATE basket set product_count=product_count+1 where  cookie=:cookie and product=:product");
        $product_update->execute(
            array(
                'cookie' => $_COOKIE['userlogin'],
                'product' => $_POST['product_id']
            )
        );
        header('location:../index.php');
    }




}

if (isset($_POST['product_idd'])) {



    $add_basket = $db->prepare('INSERT into basket set
cookie=:cookie,
product=:product
product_count=:product_count
    ');
    $add_basket->execute(
        array(
            "cookie" => $_COOKIE['userlogin'],
            'product' => $_POST['product_idd'],
            'product_count' => 1

        )
    );

    header('location:../detail.php?q=' . $_POST['product_idd']);


}

if ($_POST['plus_id']) {
    $product_update = $db->prepare("UPDATE basket set product_count=product_count+1 where  cookie='" . $_COOKIE['userlogin'] . "' and product=" . $_POST['plus_id'] . "");
    $product_update->execute();

}

if ($_POST['minus_id']) {
    $product_update = $db->prepare("UPDATE basket set product_count=product_count-1 where  cookie='" . $_COOKIE['userlogin'] . "' and product=" . $_POST['minus_id'] . "");
    $product_update->execute();
}




if (isset($_POST['costumer_name'])) {

$code=substr(md5(rand()),0,6);
$tarix= date("Y-m-d H:i:s");
$add_orders = $db->prepare('INSERT into orders set
cookie=:cookie,
code=:code,
date=:date
    ');
    $add_orders->execute(
        array(
"cookie" => $_COOKIE['userlogin'],
'code'=>$code,
'date' => date("Y-m-d H:i:s")

        )
    );

$ad=$_POST['costumer_name'];

$mesaj="Salam sifaris kodu : $code<br>Sifariş tarixi : $tarix<br>Ad soyad : $ad <br> Telefon ".$_POST['costumer_phone']." <br> Unvan ".$_POST['costumer_adress']." <br><br><hr>";

$say==0;
    $basket_scan_=$db->prepare('SELECT * from basket where cookie=:cookie order by id DESC');
    $basket_scan_->execute(array(
    
        'cookie'=>$_COOKIE['userlogin']
    ));
    while($basket_preview=$basket_scan_->fetch(PDO::FETCH_ASSOC)){
        $say++;
    $product_view=$db->prepare('SELECT * from product where id=:id ');
    $product_view->execute(array(
        "id"=>$basket_preview['product']
    ));
    
    $product_pr=$product_view->fetch(PDO::FETCH_ASSOC);
    $product_basket=$db->prepare("SELECT * from basket where cookie='".$_COOKIE['userlogin']."'  and product=".$product_pr['id']."");
    $product_basket->execute();
    $product_basket_view=$product_basket->fetch(PDO::FETCH_ASSOC);
    

    
$mesaj.='
 <br>'.$say.'. Məhsul adı : '.$product_pr['name'].'<br>
 Mehsul sayi :'.$product_basket_view['product_count'].' ədəd <br>
 Mehsul qiymeti :'.$product_basket_view['product_count']*$product_pr['price'].' azn ';
  
} 









    require("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 1; 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "zeynalov.net"; // Mail Server
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->SetLanguage("az", "language");
    $mail->CharSet = "utf-8";
    $mail->Username = "test@zeynalov.net"; // Mail
    $mail->Password = "]fMjhBpVQe5["; // Mail parol
    $mail->SetFrom("test@zeynalov.net", "E-Commerce");
    $mail->AddAddress('zeynalov.sahil@gmail.com'); // Gönderilecek mail
    $mail->Subject = "Yeni Sifaris"; // BAŞLIQ
    $mail->Body = $mesaj; // Mesaj
    if (!$mail->Send()) {
        echo "Email Gönderim Hatasi: " . $mail->ErrorInfo;
    } else {

    }


 

    $b_delete = $db->prepare('DELETE from basket where cookie="'. $_COOKIE['userlogin'] .'"   ');
    $b_delete->execute();



header('location:../basket.php?success='.$code);












}

?>