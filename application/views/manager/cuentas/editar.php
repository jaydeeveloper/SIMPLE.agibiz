<ul class="breadcrumb">
    <li><a href="<?= site_url('manager/cuentas') ?>">Cuentas</a></li> /
    <li class="active"><?= $title ?></li>
</ul>

<form class="ajaxForm" method="post" action="<?= site_url('manager/cuentas/editar_form/' . $cuenta->id) ?>">
    <fieldset>
        <legend><?= $title ?></legend>
        <div class="validacion"></div>
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= $cuenta->nombre ?>"/>
        <div class="help-block">En minusculas y sin espacios.</div>
        <label>Nombre largo</label>
        <input class="input-xxlarge" type="text" name="nombre_largo" value="<?= $cuenta->nombre_largo ?>"/>
        <label>Mensaje de bienvenida (Puede contener HTML)</label>
        <textarea name="mensaje" class="input-xxlarge"><?= $cuenta->mensaje ?></textarea>
        <label>Logo</label>
        <div id="file-uploader"></div>
        <input type="hidden" name="logo" value="<?= $cuenta->logo ?>" />
        <img class="logo" src="<?= $cuenta->logo ? base_url('uploads/logos/' . $cuenta->logo) : base_url('assets/img/simple.png') ?>" alt="logo" />
        <script>
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader'),
                action: site_url + 'manager/uploader/logo',
                onComplete: function(id, filename, respuesta) {
                    $("input[name=logo]").val(respuesta.file_name);
                    $("img.logo").attr("src", base_url + "uploads/logos/" + respuesta.file_name);
                }
            });
        </script>
        </br></br>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <a class="btn" href="<?= site_url('manager/cuentas') ?>">Cancelar</a>
        </div>
    </fieldset>
</form>