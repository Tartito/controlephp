<div class="container-fluid">
<?php
if (!isset($_SESSION['user'])) {
} else { ?>
  <div class="row justify-content-center">
    <div class="col-8">
      <p class="d-inline-flex gap-1">
        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNouvellePrestation" aria-expanded="false" aria-controls="collapseNouvellePrestation">
          Ajouter une prestation
        </button>
      </p>
      <div class="collapse" id="collapseNouvellePrestation">
        <div class="card card-body">
          <form action="admin.php?action=ajouterPrestation" method="post">
            <div class="form-group">
              <label for="libelle">Nom de la prestation</label><br>
              <input class="form-control" type="text" id="libelle" name="libelle" placeholder="Entrez le libellé de la prestation">
            </div>
            <div class="text-center">
              <br>
              <button type="submit" name="ajouterPrestation" class="btn btn-outline-success" value="ajouterPrestation">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
      
      <table class="table">
        <thead>
          <tr>
            <th>Identifiant</th>
            <th>Nom de la prestation</th>
            <th class="d-flex gap-3 justify-content-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($tabPresta as $prestation) {
              echo '
                <tr>
                  <td>' . $prestation['id'] . '</td>
                  <td>' . $prestation['libelle'] . '</td>
                  <td class="d-flex gap-3 justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModifierPrestation' . $prestation['id'] . '">
                      Modifier
                    </button>
                    <form action="admin.php?action=supprimerPrestation" method="post">
                      <input type="hidden" id="id" name="id" value="' . $prestation['id'] . '">
                      <input type="submit" class="btn btn-danger" name="supprimerPrestation" value="Supprimer">
                    </form>
                  </td>
                </tr>

                <!-- Modal Modifier Prestation -->
                <div class="modal fade" id="modalModifierPrestation' . $prestation['id'] . '" tabindex="-1" aria-labelledby="modalModifierPrestationLabel' . $prestation['id'] . '" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalModifierPrestationLabel' . $prestation['id'] . '">Modifier la prestation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="admin.php?action=modifierPrestation" method="post">
                          <div class="form-group">
                            <label for="libelle">Nom de la prestation</label><br>
                            <input type="hidden" id="id" name="id" value="' . $prestation['id'] . '">
                            <input class="form-control" type="text" id="libelle" name="libelle" value="' . $prestation['libelle'] . '" placeholder="Modifiez le nom de la prestation">
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                      </div>
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
<?php } ?>
</div>
