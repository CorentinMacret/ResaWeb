<?php
//avant de pouvoir utiliser le code , il faut diposer d'une base de donnée 'tblusers' avec comme attribut : EmailId , Password et Fullname .
//il faut aussi penser à avoir une page index qui appelle cette fonction Php ainsi que la fentre de login.
if(isset($_POST['login']))//si utilisateur clic sur 'login' du formulaire ( fenetre de connection si dessous)
{
$email=$_POST['email'];//recuperation de l'email
$password=md5($_POST['password']);//idem pour mot de passe
$sql ="SELECT EmailId,Password,FullName FROM tblusers WHERE EmailId=:email and Password=:password";//selectionner les infos dans la base de donnée tbluser , si Emailid = à l'email et l'ID du mot de passe = MDP ...
$query= $dbh -> prepare($sql);//preparation du sql
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();// en PDOStatement => execute la requete 
$results=$query->fetchAll(PDO::FETCH_OBJ);//fetchall
if($query->rowCount() > 0)//a partir de 0 
{
$_SESSION['login']=$_POST['email'];
$_SESSION['fname']=$results->FullName;
$currentpage=$_SERVER['REQUEST_URI'];
echo "<script type='text/javascript'> document.location = '$currentpage'; </script>";//l'utilisateur est connecté , ' il reste/est redirigé ' sur la page d'accueil qui est la page actuelle .
} else{
  //sinon marquer en message 'erreur'
  echo "<script>alert('erreur');</script>";

}

}

?>
<!-- fenetre se connecter -->
<div class="modal fade" id="loginform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Se connecter</h3><!--bouton se connecter-->
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="login_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post"><!--formulaire en POST car 'renvoie'au code php-->
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="email*"><!--champs pour mettre son Email-->
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="mot de passe*"><!--champs pour mettre son mot de passe-->
                </div>
                <div class="form-group checkbox">
                   <input type="checkbox" id="remember"><!--une petite checkbox se rappeller de moi -->
               
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="Login" class="btn btn-block"><!--boutton de type submit , le php va recupérer les données et faire le code de vérification-->
                </div>
              </form>
            </div>
           
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Pas de compte? <a href="#signupform" data-toggle="modal" data-dismiss="modal">s'enregister!</a></p><!--si pas de compte renvoie vers fenetre de création de compte et appelle une autre fonction-->
        <p><a href="#forgotpassword" data-toggle="modal" data-dismiss="modal">mot de passe oublié ?</a></p><!--renvoie vers page pour réinitialiser le mot de passe et appelle la ''fonction'' php forgotpassword-->
      </div>
    </div>
  </div>
</div>
<!-- fin de la fenetre -->