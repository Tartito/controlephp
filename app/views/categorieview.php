<div class="container-fluid">
<?php
if (!isset($_SESSION['user'])) {
    echo '<div class="d-flex justify-content-center align-items-center flex-column">';
    echo '<h2 class="text-center">Veuillez vous connecter pour accéder à cette page !</h2>';
    echo '<p class="text-center">Vous devez être connecté pour voir les informations complètes.</p>';
    echo '</div>';
} else { ?>
  <div class="row justify-content-center mt-4">
    <div class="col-lg-10 col-md-12">
      <div class="card">
        <div class="card-header bg-success text-white">
          <h4>Gestion des Catégories</h4>
        </div>
        <div class="card-body">
          <!-- Bouton Créer une catégorie -->
          <p class="d-inline-flex gap-1 mb-3">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreate" aria-expanded="false" aria-controls="collapseCreate">
              Créer une catégorie
            </button>
          </p>

          <!-- Formulaire pour créer une catégorie -->
          <div class="collapse" id="collapseCreate">
            <div class="card card-body">
              <form action="admin.php?action=createCategorie" method="post">
                <div class="form-group">
                  <label for="libelle">Libellé</label><br>
                  <input class="form-control" type="text" id="libelle" name="libelle">
                </div>
                <div class="text-center">
                  <br>
                  <button type="submit" name="createCategorie" class="btn btn-outline-success" value="createCategorie">Créer</button>
                </div>
              </form>
            </div>
          </div>

          <!-- Tableau des catégories -->
          <table class="table table-striped mt-4">
            <thead>
              <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th class="d-flex gap-3 justify-content-end">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($tabCategorie as $value) {
                  echo '
                    <tr>
                      <td>' . $value['id'] . '</td>
                      <td>' . $value['libelle'] . '</td>
                      <td class="d-flex gap-3 justify-content-end">
                        <!-- Bouton Modifier -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal' . $value['id'] . '">
                          Modifier
                        </button>

                        <!-- Formulaire Supprimer -->
                        <form action="admin.php?action=deleteCategorie" method="post">
                          <input type="hidden" id="id" name="id" value="' . $value['id'] . '">
                          <input type="submit" class="btn btn-danger" name="deleteCategorie" value="Supprimer">
                        </form>
                      </td>
                    </tr>
                    <!-- Modal Modifier -->
                    <div class="modal fade" id="editModal' . $value['id'] . '" tabindex="-1" aria-labelledby="editModal' . $value['id'] . '" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModal' . $value['id'] . '">Modifier la catégorie</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="admin.php?action=editCategorie" method="post">
                              <div class="form-group">
                                <label for="libelle">Libellé</label><br>
                                <input type="hidden" id="id" name="id" value="' . $value['id'] . '">
                                <input class="form-control" type="text" id="libelle" name="libelle" value="' . $value['libelle'] . '">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                              <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  ';
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
</div>
