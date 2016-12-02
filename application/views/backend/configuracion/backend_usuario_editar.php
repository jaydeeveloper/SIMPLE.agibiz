<script>
    $(document).ready(function(){
        
        $("#rol option").on("click",function() {
            var foo = [];
            $('#rol :selected').each(function(i, selected){ 
              foo.push($.trim($(selected).text()));
            });
            if (inArray("reportes", foo)) {
                $("#div_procesos").show();
            } else {
                $("#div_procesos").hide();
            }
        });

        function inArray(needle, haystack) {
            var length = haystack.length;
            for(var i = 0; i < length; i++) {
                if(haystack[i] == needle){
                    return true
                }else if(haystack[i] == "gestion"){
                    return true
                }else if(haystack[i] == "seguimiento"){
                    return true
                }
            }
            return false;
        }
    });
</script>

<div class="row-fluid">

    <div class="span3">
        <?php $this->load->view('backend/configuracion/sidebar') ?>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li>
                <a href="<?= site_url('backend/configuracion') ?>">Configuración</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="<?= site_url('backend/configuracion/usuarios') ?>">Usuarios</a> <span class="divider">/</span>
            </li>
            <li class="active"><?= isset($usuario) ?$usuario->email:'Crear' ?></li>
        </ul>

        <form class="ajaxForm" method="post" action="<?= site_url('backend/configuracion/backend_usuario_editar_form/' . (isset($usuario)?$usuario->id:'')) ?>">
            <fieldset>
                <legend>Editar usuario</legend>
                <div class="validacion"></div>
                <label>E-Mail</label>
                <input type="text" name="email" value="<?=isset($usuario)?$usuario->email:''?>" <?=  isset($usuario)?'disabled':''?>/>
                <label>Contraseña</label>
                <input type="password" name="password" value=""/>
                <?php if(isset($usuario)):?><span class="help-inline">Solo si desea modificarla</span><?php endif ?>
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirm" value=""/>
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?=isset($usuario)?$usuario->nombre:''?>"/>
                <label>Apellidos</label>
                <input type="text" name="apellidos" value="<?=isset($usuario)?$usuario->apellidos:''?>"/>
                <label>Rol</label>
                <?php 
                    $roles= array("super", "modelamiento", "seguimiento","operacion","gestion","desarrollo","configuracion","reportes");
                    $longitud = count($roles);

                    $valores= isset($usuario->rol) ? explode(",", $usuario->rol) : '';
                ?>         
                <select id="rol" name="rol[]"  class="input-xxlarge" multiple>
                    <?php  
                        for($o=0; $o<$longitud; $o++){ 
                    ?>
                            <option value="<?= $roles[$o] ?>" <?=  isset($usuario) && in_array($roles[$o], $valores) ? 'selected':''?> > <?= $roles[$o] ?> </option>                    
                    <?php  
                        } 
                    ?>
                </select>

                <?php if(isset($usuario) && (count(explode(",",$usuario->procesos)) > 1 or in_array('seguimiento', explode(",", $usuario->rol)) or in_array('gestion', explode(",", $usuario->rol)) or in_array('reportes', explode(",", $usuario->rol)) )): ?>
                <div id="div_procesos" style="display: block">
                <?php else: ?>
                <div id="div_procesos" style="display: none">
                <?php endif; ?>
                <label>Procesos</label>
                <select name="procesos[]" class="input-xxlarge" multiple>
                    <?php
                        $procesos_usuario = explode(",",$usuario->procesos);
                        foreach ($procesos as $p) {
                    ?>
                            <option value="<?= $p->id ?>"<?= in_array($p->id, $procesos_usuario) ? 'selected':''?> > <?= $p->nombre ?> </option>                    
                <?php } ?>
                </select>
                </div>

                <div class="help-block">
                    <ul>
                        <li>super: Tiene todos los privilegios del sistema.</li>
                        <li>modelamiento: Permite modelar y diseñar el funcionamiento del trámite.</li>
                        <li>seguimiento: Permite hacer seguimiento de los tramites.</li>
                        <li>operacion: Permite hacer seguimiento y operaciones sobre los tramites como eliminacion y edición.</li>
                        <li>gestión: Permite acceder a reportes de gestion con privilegio de visualización.</li>
                        <li>reportes: Permite acceder y configurar reportes de gestión y uso de la plataforma.</li>
                        <li>desarrollo: Permite acceder a la API de desarrollo, para la integracion con plataformas externas.</li>
                        <li>configuracion: Permite configurar los usuarios y grupos de usuarios que tienen acceso al sistema.</li>
                    </ul>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a class="btn" href="<?=site_url('backend/configuracion/backend_usuarios')?>">Cancelar</a>
                </div>
            </fieldset>
        </form>

    </div>
</div>