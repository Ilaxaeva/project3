<?php 
include 'core/config.php';
include 'header.php';

?>
<style>

#cart {
  max-width: 1440px;
  padding-bottom: 60px;
  margin: auto;
}
.form div {
  margin-bottom: 0.4em;
}
.cartItem {
  --bs-gutter-x: 1.5rem;
}
.cartItemQuantity,
.proceed {
  background: #f4f4f4;
}
.items {
  padding-right: 30px;
}
#btn-checkout {
    border-radius: 7px;
  min-width: 100%;
}

/* stasysiia.com */
@import url("https://fonts.googleapis.com/css2?family=Exo&display=swap");
body {
  background-color: #fff;

  font-size: 22px;
  margin: 0;
  padding: 0;
  color: #111111;
  justify-content: center;
  align-items: center;
}
a {
  color: #0e1111;
  text-decoration: none;
}
.btn-check:focus + .btn-primary,
.btn-primary:focus {
  color: #fff;
  background-color: #111;
  border-color: transparent;
  box-shadow: 0 0 0 0.25rem rgb(49 132 253 / 50%);
}
button:hover,
.btn:hover {
  box-shadow: 5px 5px 7px #c8c8c8, -5px -5px 7px white;
}
button:active {
  box-shadow: 2px 2px 2px #c8c8c8, -2px -2px 2px white;
}

/*PREVENT BROWSER SELECTION*/
a:focus,
button:focus,
input:focus,
textarea:focus {
  outline: none;
}
/*main*/
main:before {
  content: "";
  display: block;
  height: 88px;
}
h1 {
  font-size: 2.4em;
  font-weight: 600;
  letter-spacing: 0.15rem;
  text-align: center;
  margin: 30px 6px;
}
h2 {
  color: rgb(37, 44, 54);
  font-weight: 700;
  font-size: 2.5em;
}
h3 {
  border-bottom: solid 2px #000;
}
h5 {
  padding: 0;
  font-weight: bold;
  color: #92afcc;
}
p {
  color: #333;
  font-family: "Roboto", sans-serif;
  margin: 0.6em 0;
}
h1,
h2,
h4 {
  text-align: center;
  padding-top: 16px;
}
/* yukito bloody */
.back {
  position: relative;
  top: -30px;
  font-size: 16px;
  margin: 10px 10px 3px 15px;
}
.inline {
  display: inline-block;
}

.shopnow,
.contact {
  background-color: #000;
  padding: 10px 20px;
  font-size: 30px;
  color: white;

  letter-spacing: 1px;
  transition: all 0.5s;
  cursor: pointer;
}
.shopnow:hover {
  text-decoration: none;
  color: white;
  background-color: #198754;
}
/* for button animation*/
.shopnow span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: all 0.5s;
}
.shopnow span:after {
  content: url("https://badux.co/smc/codepen/caticon.png");
  position: absolute;
  font-size: 30px;
  opacity: 0;
  top: 2px;
  right: -6px;
  transition: all 0.5s;
}
.shopnow:hover span {
  padding-right: 25px;
}
.shopnow:hover span:after {
  opacity: 1;
  top: 2px;
  right: -6px;
}
.ma {
  margin: auto;
}
.price {
  color: slategrey;
  font-size: 2em;
}
#mycart {
  min-width: 90px;
}
#cartItems {
  font-size: 17px;
}
#product .container .row .pr4 {
  padding-right: 15px;
}
#product .container .row .pl4 {
  padding-left: 15px;
}

.cont_b {
  border: 1px solid green ;
  border-radius:5px;
  margin:5px
}


</style><header class="bg-success py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Səbətim</h1>
                
                </div>
            </div>
        </header>

<?php if($basket_count==0){
if(isset($_GET['success'])){
echo "<center><br><br><br>Sifarisiniz qebul edilidi.Sifaris kodu :".$_GET['success']."<br><br><br></center>";
}else {
 echo " <center><img style='color:red;margin-bottom:80px' width='80px' src='https://cdn-icons-png.flaticon.com/512/2797/2797387.png'><br><h4 style='color:red;margin-bottom:80px'>Sizin səbətinizdə məhsul yoxdur !!!</h4></center>";
 
}
}else {?>

      
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<main id="cart" style="max-width:1200px">

  <div class="container-fluid">
    <div class="row align-items-start">
      <div class="col-12 col-sm-8 items">
        <!--1-->

        <?php

$basket_scan_=$db->prepare('SELECT * from basket where cookie=:cookie order by id DESC');
$basket_scan_->execute(array(

    'cookie'=>$_COOKIE['userlogin']
));
while($basket_preview=$basket_scan_->fetch(PDO::FETCH_ASSOC)){

$product_view=$db->prepare('SELECT * from product where id=:id ');
$product_view->execute(array(
    "id"=>$basket_preview['product']
));

$product_pr=$product_view->fetch(PDO::FETCH_ASSOC);
  
// USERE GORE PRODUCT MELLUMATLARİNİN GETİRLEMESİ
    

    
$product_basket=$db->prepare("SELECT * from basket where cookie='".$_COOKIE['userlogin']."'  and product=".$product_pr['id']."");
$product_basket->execute();
$product_basket_view=$product_basket->fetch(PDO::FETCH_ASSOC);









    ?>


        <div class="cartItem row align-items-start">
          <div class="col-3 mb-2">
            <img  style="width:80px;border-radius:7px;" src="assets/<?php echo $product_pr['img'] ?>" alt="art image">
          </div>
          <div class="col-3 mb-2">
            <h6 class=""><?php echo $product_pr['name'] ?></h6>
           
          </div>
          <div class="col-2">
            <p class="cartItemQuantity p-1 text-center">
              



            
            <button class="cont_b plus" id="<?php echo $product_pr['id'] ?>">+</button>
            
            
           <span class="product_count" id="<?php echo $product_pr['id'] ?>_count"> <?php echo $product_basket_view['product_count'] ?></span>
            
            
            <button class="cont_b minus" id="<?php echo $product_pr['id'] ?>">-</button></p>





          </div>
          <div class="col-2">
            <p class="cartItem1Price"><?php echo $product_basket_view['product_count']*$product_pr['price'] ?> Azn</p>
          </div>
           <div class="col-2">
            <a  href="core/funksiya.php?dbasket=<?php echo $product_pr['id'] ?>" style="color:red;text-decoration:none;" ><i class="far fa-trash-alt"></i> Sil</a>
          </div>
          
        </div>
     
        <hr>

<?php } ?>
      </div>
      <div class="col-12 col-sm-4 p-3 proceed form">
        <div class="row m-0">
          <div class="col-sm-8 p-0">
            <h6>Məshul qiyməti</h6>
          </div>
          <div class="col-sm-4 p-0">
            <p id="subtotal">$132.00</p>
          </div>
        </div>
        <div class="row m-0">
          <div class="col-sm-8 p-0 ">
            <h6>Vergi</h6>
          </div>
          <div class="col-sm-4 p-0">
            <p id="tax">$6.40</p>
          </div>
        </div>
        <hr>
        <div class="row mx-0 mb-2">
          <div class="col-sm-8 p-0 d-inline">
            <h5>Cəm Ödəniş</h5>
          </div>
          <div class="col-sm-4 p-0">
            <p id="total">$138.40</p>
          </div>
        </div>
        <a href="#"><button data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn-checkout" class="shopnow"><span>Sifarişi tamamla</span></button></a>
      </div>
    </div>
  </div>

<?php } ?>




             
           

</main>





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alıcı məllumatları</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="core/funksiya.php" >
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Ad Soyad</label>
    <input type="text" class="form-control" name="costumer_name" id="exampleInputEmail1" aria-describedby="emailHelp">
  
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Telefon</label>
    <input type="number" class="form-control" name="costumer_phone" id="exampleInputPassword1">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">E-mail</label>
    <input type="email" class="form-control" name="costumer_mail" id="exampleInputPassword1">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Ünvan</label>
    <input type="text" class="form-control" name="costumer_adress" id="exampleInputPassword1">
  </div>
  

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
        <button type="submit" class="btn btn-primary">Göndər</button>
      </form>
      </div>
    </div>
  </div>
</div>







<footer class="container">
</footer>
                </div>
            </div>
        </section>
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy;  2023</p></div>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>

    <script>


$(document).ready(function (){



var sum = 0;
    $('.cartItem1Price').each(function(){
        sum += parseInt(this.innerHTML)
    })


  $('#subtotal').text(sum+" azn");
  var vergi=(sum*18)/100;
  $('#tax').text(vergi+" azn");
  $('#total').text(sum+vergi+" azn");

})





$('.plus').click(function(){
var plus_id=$(this).attr('id');
var plus_count=$('#'+plus_id+"_count").text();
$('#'+plus_id+"_count").text(eval(plus_count+"+"+1));

$.ajax({

type:'POST',
url:'core/funksiya.php',
data : {plus_id:plus_id,plus_count:plus_count},
success:function(cavab){

  location.reload();
  
}




})



});




$('.minus').click(function(){
  var minus_id=$(this).attr('id');




var plus_count=$('#'+minus_id+"_count").text();


if(plus_count==1){
alert('Minimal say 1 olmaldir');
}else {
  $('#'+minus_id+"_count").text(eval(plus_count+"-"+1));

  
$.ajax({

type:'POST',
url:'core/funksiya.php',
data : {minus_id:minus_id},
success:function(cavab){

location.reload();
  
}




})
}


})

    </script>
    </body>
</html>
