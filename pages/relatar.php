<?php require "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home | Estac</title>
</head>

<body>
  <div class="content_main">
    <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Título do Ticket</label>
      <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Erro 202... etc">
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Especificação do erro</label>
      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label for="formFileSm" class="form-label">Print do erro exibido</label>
      <input class="form-control form-control-sm" id="formFileSm" type="file" accept="image/png, image/jpeg, image/jpg">
    </div>
    <div class="col-12 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">Abrir chamado</button>
    </div>
  </div>
</body>
</div>
</div>
<script>
  $(document).ready(function() {
    $('#sidebar_active').on('click', function() {
      $('.sidebar').toggleClass('active');
    });
  });
</script>
<script src="../js/jquery-3.7.1.min.js"></script>
<script src="../js/javascript.js"></script>
</body>

</html>