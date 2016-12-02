<div class="row-fluid">
    
    <div class="span3">
        <?php $this->load->view('backend/configuracion/sidebar') ?>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li>
                <a href="<?=site_url('backend/configuracion')?>">Configuración</a> <span class="divider">/</span>
            </li>
            <li class="active">Selección</li>
        </ul>
        
        <?php $this->load->view('messages') ?>
        
        <p><a class="btn btn-success" href="<?=site_url('backend/configuracion/plantillas')?>"><i class="icon-file icon-white"></i> Nueva Plantilla</a></p>
        
        <table class="table">
            <tr>
                <th>Plantilla</th>
                <th>Vista previa</th>
                <th>Actual en uso</th>
                <th>Acciones</th>
            </tr>
          <?php foreach($config as $p): ?>
          <tr>
                <td><?=$p->nombre_visible?></td>

                <?php
                
                if ($p->nombre=='default') {
                    $ruta = 'uploads/themes/'.$p->nombre.'/preview.png';
                } else {
                    $ruta = 'uploads/themes/'.$p->cuenta_id.'/'.$p->nombre.'/preview.png';
                }
                ?>
                <td><img class="theme" height="140" width="280" src="<?=base_url($ruta)?>" alt="theme" /></td>
                
                <?php
                $condicion = "No";
                if ($config_id==$p->id) {
                    $condicion = "Si";
                }
                ?>
                <td><?=$condicion?></td>
                <td>
                    <a class="btn btn-primary" href="<?=site_url('backend/configuracion/plantilla_seleccion/'.$p->id)?>"><i class="icon-edit icon-white"></i> Seleccionar</a>
                    <?php if ($p->nombre!='default' && $p->cuenta_id>0): ?>
                    <a class="btn btn-danger" href="<?=site_url('backend/configuracion/plantilla_eliminar/'.$p->id)?>" onclick="return confirm('¿Está seguro que desea eliminar?')"><i class="icon-remove icon-white"></i> Eliminar</a>
                    <?php endif; ?>
                    
                </td>
            </tr>
          <?php endforeach; ?>
        </table>
    </div>
</div>