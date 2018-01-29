<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
        
    <!-- JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
            
    <title>Bienvéo entrance</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Insertion Bienvéo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="#">Créer des annonces <span class="sr-only">(current)</span></a>
            </div>
        </div>
    </nav>
    <br>
    <div class="container-fluid">
     <form method="post" action="xml_aj.php" enctype="multipart/form-data">
     <center><h4>Lot</h4></center>
     <div class="row">
        <div class="col-5 offset-1">    
           <div class="form-group">
              <label for="exampleFormControlInput1">N° du lot </label>
              <input type="text" class="form-control" name="lklo" id="exampleFormControlInput1" placeholder="********LO" required>
           </div>
           <div class="form-group">
              <label for="exampleFormControlInput1">Titre de l'annonce </label>
              <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Titre de l'annonce" name="titre" required>
           </div>
           <div class="form-group">
               <label for="exampleFormControlTextarea1">Description de l'annonce</label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="18" name="corps" required></textarea>
           </div>
           <div class="form-group">
              <label for="exampleFormControlInput1">Prix </label>
              <input type="number" class="form-control" id="exampleFormControlInput1" name="prix" required>
           </div>
      </div>
      <div class="col-4 offset-1">
        <br><br><br><br><br><br>
        <h5>Ajouter des photos</h5>
        Photo 1 :
        <div class="input-group">
            <input type="file" name="photo1">
        </div>
        <br>
        Photo 2 :
        <div class="input-group">
            <input type="file" name="photo2">
        </div>
        <br>
        Photo 3 :
        <div class="input-group">
            <input type="file" name="photo3">
        </div>
        <br>
        Photo 4 :
        <div class="input-group">
            <input type="file" name="photo4">
        </div>
        <br>
        <h5>Le bien est-il disponible ?</h5>
        <br>
        <div class="form-group">
            <div class="form-check">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-check-label" for="gridCheck">
                    Disponible immédiatement ?
                  </label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input class="form-check-input" type="checkbox" id="gridCheck" name="check_dispo">
            </div>
        </div>
    </div>
</div>              
<center><button type="submit" class="btn btn-success">Enregistrer l'annonce</button></center>
</form> 
</div>
</body>
</html>