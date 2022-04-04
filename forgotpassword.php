<?php
//avant de pouvoir utiliser le code , il faut diposer d'une base de donnée 'tblusers' avec comme attribut : EmailId , Password et Fullname .
//il faut aussi penser à avoir une page index ( ou le header ) qui appelle cette fonction Php ainsi que la fentre de login.

if(isset($_POST['update']))//si boutton submit de nom 'update' est cliquer...
  {
$email=$_POST['email'];//réccupération  de l'email
$mobile=$_POST['mobile'];//du mobile
$newpassword=md5($_POST['newpassword']);//nouveau mot de passe
  $sql ="SELECT EmailId FROM tblusers WHERE EmailId=:email and ContactNo=:mobile";
$query= $dbh -> prepare($sql);//selection de l'email dans tblusers QUAND l'id email = à l'email ET que le mobile = à celui renseigné dans la Base de donnée.
$query-> bindParam(':email', $email, PDO::PARAM_STR);//verification de conformité
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update tblusers set Password=:newpassword where EmailId=:email and ContactNo=:mobile";// on update le mot de passe de l'utilisateur dans la base de donnée .
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();//on éxécute le code pour changer son MDP ,si oublié .
echo "<script>alert('Mot de passe changer !');</script>";
}// echo pour message de validation
else {
echo "<script>alert('Email ou mobile non valide !');</script>"; 
}// echo d'erreur
}

?>
  <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)//si nouveau MDP = au nouveau MDP renseigner par l'utilisateur alors... 
{//si php retourne une confirmation  dire...
alert("Nouveau mot de passe confirmé !");//mdp OK
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
<div class="modal fade" id="forgotpassword">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
<!--Mise en page de la fenetre de changement de MDP-->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Récupération de mot de passe</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="forgotpassword_wrap">
            <div class="col-md-12">
              <form name="chngpwd" method="post" onSubmit="return valid();">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="votre Email*" required="">
                </div>
  <div class="form-group">
                  <input type="text" name="mobile" class="form-control" placeholder="votre Mobile*" required="">
                </div>
  <div class="form-group">
                  <input type="password" name="newpassword" class="form-control" placeholder="Nouveau mot de passe*" required="">
                </div>
  <div class="form-group">
                  <input type="password" name="confirmpassword" class="form-control" placeholder="Confirmer le mot de passe*" required=""><!--name = confirmpassword car il renvoie au script-->
                </div>
                <div class="form-group">
                  <input type="submit" value="Réinitialiser le mot de passe" name="update" class="btn btn-block"><!--de type submit pour ''appeller la fonction'' PHP-->
                </div>
              </form>
              <div class="text-center">
                <p class="gray_text">Pour des raisons de sécurité, nous ne stockons pas votre mot de passe. Votre mot de passe sera réinitialisé et un nouveau vous sera envoyé.</p>
                <p><a href="#loginform" data-toggle="modal" data-dismiss="modal"><i class="fa fa-angle-double-left" aria-hidden="true"></i>Retour connexion</a></p><!--boutton retour vers page login-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>