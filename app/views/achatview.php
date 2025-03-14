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
        <div class="card-header bg-primary text-white">
          <h4>Liste des Achats</h4>
        </div>
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Prestation</th>
                <th>Nombre</th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($tabAchat as $value) {
                  echo '
                    <tr>
                      <td>' . $value['id_ticket'] . '</td>
                      <td>' . $value['prestation'] . '</td>
                      <td>' . $value['nombre'] . '</td>
                    </tr>
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
