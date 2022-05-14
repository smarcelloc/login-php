<?php if ($data = getFlash('message')) : ?>
  <div class="message <?= $data['type'] ?? '' ?>"><?= $data['message'] ?? '' ?></div>
<?php endif ?>