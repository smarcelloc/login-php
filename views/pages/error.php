<?php $this->layout("pages/_theme", ['head' => $head]); ?>

<div class="page">
    <h1>Ooops, erro <?= $error ?></h1>
    <p>Desculpe por isso, caso o problema persista, por favor entre em contato conosco.</p>
    <p><a class="btn btn-blue" href="<?= $router->route("web.login"); ?>" title="<?= SITE["name"]; ?>">VOLTAR!</a></p>
</div>