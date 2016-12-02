<div class="row-fluid">
    
    <div class="span3">
        <?php $this->load->view('backend/configuracion/sidebar') ?>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li>
                <a href="<?=site_url('backend/configuracion')?>">Configuración</a> <span class="divider">/</span>
            </li>
            <li class="active">Selección Conector</li>
        </ul>
        
        <?php $this->load->view('messages') ?>
        
        <table class="table">
            <tr>
                <th>Conector</th>
                <th>Vista previa</th>
                <th>Actual en uso</th>
                <th>Acciones</th>
            </tr>
          <?php foreach($config as $p): ?>
          <tr>
                <td><?=$p->nombre_visible?></td>
                <td><img class="theme" height="140" width="280" src="<?=base_url('uploads/connectors/'.$p->nombre.'.png')?>" alt="connectors" /></td>
                <?php
                $condicion = "No";
                if ($config_id==$p->id) {
                    $condicion = "Si";
                }
                ?>
                <td><?=$condicion?></td>
                <td>
                    <a class="btn btn-primary" href="<?=site_url('backend/configuracion/modelador/'.$p->id)?>"><i class="icon-edit icon-white"></i> Seleccionar</a>
                </td>
            </tr>
          <?php endforeach; ?>
        </table>
    </div>
</div>