<br>
<div class="container-fluid">
<?php
if(!isset($_SESSION['user'])) {
}else {?>
  <div class="row justify-content-center">
    <div class="col-8">
    <p class="d-inline-flex gap-1">
      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreate" aria-expanded="false" aria-controls="collapseCreate">
      Créer un droit
      </button>
    </p>
    <div class="collapse" id="collapseCreate">
      <div class="card card-body">
      <form action="admin.php?action=createDroits" method="post">
        <div class="form-group">
          <label for="libelle">Libellé</label><br>
          <input class="form-control" type="text" id="libelle" name="libelle" placeholder="Entrez le libellé du droit">
        </div>
        <div class="text-center">
          <br>
          <button type="submit" name="createDroits" class="btn btn-outline-success" value="createDroits">Créer</button>
        </div>
      </form>
      </div>
    </div>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Libellé</th>
            <th class="d-flex gap-3 justify-content-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($tabDroits as $value) {
              echo '
                <tr>
                  <td>'.$value['id'].'</td>
                  <td>'.$value['libelle'].'</td>
                  <td class="d-flex gap-3 justify-content-end">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal'.$value['id'].'">
                      Modifier
                    </button>

                    <form action="admin.php?action=deleteDroits" method="post">
                      <input type="hidden" id="id" name="id" value="'.$value['id'].'">
                      <input type="submit" class="btn btn-danger" name="deleteDroits" value="Supprimer">
                    </form>
                  </td>
                  <div class="modal fade" id="editModal'.$value['id'].'" tabindex="-1" aria-labelledby="editModal'.$value['id'].'" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editModal'.$value['id'].'">Modifier le droit</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="admin.php?action=editDroits" method="post">
                            <div class="form-group">
                              <label for="libelle">Libellé</label><br>
                              <input type="hidden" id="id" name="id" value="'.$value['id'].'">
                              <input class="form-control" type="text" id="libelle" name="libelle" value="'.$value['libelle'].'">
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
                </tr>
              ';
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
<?php } ?>
</div>
