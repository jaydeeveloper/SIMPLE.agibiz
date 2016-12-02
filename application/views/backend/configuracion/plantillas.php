<div class="row-fluid">

    <div class="span3">
        <?php $this->load->view('backend/configuracion/sidebar') ?>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li>
                <a href="<?= site_url('backend/configuracion') ?>">Configuración</a> <span class="divider">/</span>
            </li>
            <li class="active">Plantillas</li>
        </ul>

        <form class="ajaxForm" method="post" action="<?= site_url('backend/configuracion/plantillas_form/') ?>">
            <fieldset>
                <legend>Cargar Nueva Plantilla</legend>
                <div class="validacion"></div>
                <label>Nombre Plantilla</label>
                <input class="input-xxlarge" type="text" name="nombre_visible" value=""/>
                <div id="file-uploader"></div>
                <input type="hidden" name="nombre_plantilla" value="" />
                <img class="theme" height="140" width="280" src="" alt="" />
                <script>
                    var uploader = new qq.FileUploader({
                        element: document.getElementById('file-uploader'),
                        action: site_url+'backend/uploader/themes',
                        onComplete: function(id,filename,respuesta){
                            $("input[name=nombre_plantilla]").val(respuesta.folder);
                            $("img.theme").attr("src",base_url+respuesta.full_path);
                        }
                    });
                </script> 
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a class="btn" href="<?=site_url('backend/configuracion/plantilla_seleccion')?>">Cancelar</a>
                </div>
                
            </fieldset>
        </form>
    </div>
</div>