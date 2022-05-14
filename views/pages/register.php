<?php $this->layout("pages/_theme", ['head' => $head]); ?>

<div class="main_content_box">
    <div class="login">
        <form class="form" action="<?= $router->route("auth.register"); ?>" method="post" autocomplete="off">
            <div class="login_form_callback">
                <?php $this->insert('pages/_messageFlash') ?>
            </div>

            <div class="label_2">
                <label>
                    <span class="field">Nome:</span>
                    <input value="<?= $_POST['first_name'] ?? '' ?>" type="text" name="first_name" placeholder="Primeiro nome:" />
                </label>

                <label>
                    <span class="field">Sobrenome:</span>
                    <input value="<?= $_POST['last_name'] ?? '' ?>" type="text" name="last_name" placeholder="Último nome:" />
                </label>
            </div>

            <label>
                <span class="field">E-mail:</span>
                <input value="<?= $_POST['email'] ?? '' ?>" type="email" name="email" placeholder="Informe seu e-mail:" />
            </label>

            <label>
                <span class="field">Senha:</span>
                <input autocomplete="password" type="password" name="password" placeholder="Informe sua senha:" />
            </label>

            <div class="form_actions">
                <button class="btn btn-green btn-full">Criar Conta</button>
            </div>
        </form>

        <div class="form_register_action">
            <p>Já tem conta?</p>
            <a href="<?= $router->route("web.login"); ?>" class="btn btn-blue">Fazer Login</a>
        </div>
    </div>
</div>

<?php $this->start("scripts"); ?>
<script src="<?= asset("/js/form.js"); ?>"></script>
<?php $this->end(); ?>