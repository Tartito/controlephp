<br>
<div class="container-fluid">
<?php
if(!isset($_SESSION['user'])) {
} else { ?>
  <div class="row justify-content-center">
    <div class="col-10">
      <div class="accordion" id="accordionExemple">
        <div class="accordion-item">
          <h2 class="accordion-header" id="enTeteUn">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUn" aria-expanded="true" aria-controls="collapseUn">
              Utilisateurs
            </button>
          </h2>
          <div id="collapseUn" class="accordion-collapse collapse show" aria-labelledby="enTeteUn" data-bs-parent="#accordionExemple">
            <div class="accordion-body">
              <table class="table">
                <thead>
                  <tr>
                    <th>Identifiants</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Mot de passe</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  foreach ($users as $user) {
                    echo '
                     <tr>
                       <form action="admin.php?action=user" method="post">
                          <td>
                          '.$user->id_users().'
                           <input type="hidden" class="form-control" value="'.$user->id_users().'" name="id_users">
                          </td> 
                          <td>
                           <input type="text" class="form-control" value="'.$user->pseudo().'" name="pseudo">
                          </td> 
                          <td>
                           <input type="text" class="form-control" value="'.$user->mail().'" name="mail">
                          </td> 
                          <td>
                           <input type="password" class="form-control" value="'.$user->password().'" name="password">
                          </td> 
                          <td>
                            <button class="btn btn-outline-warning" type="submit" value="modifUser" name="submitUser">Modifier</button>
                          </td> 
                          <td>
                          <button class="btn btn-outline-danger" type="submit" value="deleteUser" name="submitUser">Supprimer</button>
                          </td>
                       </form>
                     </tr>
                   ';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="enTeteDeux">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeux" aria-expanded="false" aria-controls="collapseDeux">
              Auteurs
            </button>
          </h2>
          <div id="collapseDeux" class="accordion-collapse collapse" aria-labelledby="enTeteDeux" data-bs-parent="#accordionExemple">
            <div class="accordion-body">
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="enTeteTrois">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTrois" aria-expanded="false" aria-controls="collapseTrois">
              Livres
            </button>
          </h2>
          <div id="collapseTrois" class="accordion-collapse collapse" aria-labelledby="enTeteTrois" data-bs-parent="#accordionExemple">
            <div class="accordion-body">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
</div>
