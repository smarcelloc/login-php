<?php $this->layout("pages/_theme", ['head' => $head]); ?>

<div class="main_content_box">
    <div class="login">
        <form class="form" name="reset" action="<?= $router->route("auth.reset"); ?>" method="post" autocomplete="off">
            <div class="login_form_callback">
                <?= getFlash(''); ?>
            </div>

            <label>
                <span class="field">Nova Senha:</span>
                <input value="" type="password" name="password" placeholder="Cadastre uma nova senha:" />
            </label>

            <label>
                <span class="field">Confirmação:</span>
                <input value="" type="password" name="password_re" placeholder="Repita sua nova senha:" />
            </label>

            <div class="form_actions">
                <button class="btn btn-green btn-full">Atualizar Minha Senha</button>
            </div>
        </form>

        <div class="form_register_action">
            <p>Você também pode:</p>
            <a href="<?= $router->route("web.login"); ?>" class="btn btn-blue">Voltar ao Login</a>
        </div>
    </div>
</div>

<?php $this->start("scripts"); ?>
<script src="<?= asset("/js/form.js"); ?>"></script>
<?php $this->end(); ?>