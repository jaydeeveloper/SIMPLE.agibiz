<script src="<?= base_url() ?>assets/js/modelador-acciones.js" type="text/javascript"></script>

<ul class="breadcrumb">
    <li class="active">
        Gestion
    </li>
</ul>



<table class="table">
    <thead>
        <tr>
            <th>Proceso</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($procesos as $p): ?>
        <?php  if(is_null((UsuarioBackendSesion::usuario()->procesos))): ?>    
        <tr>
            <td><?=$p->nombre?></td>
            <td>
                <a href="<?=site_url('backend/reportes/listar/'.$p->id)?>" class="btn btn-primary"><i class="icon-eye-open icon-white"></i> Ver Reportes</a>
            </td>
        </tr>
        <?php elseif( in_array( $p->id,explode(',',UsuarioBackendSesion::usuario()->procesos))): ?>
        <tr>
            <td><?=$p->nombre?></td>
            <td>
                <a href="<?=site_url('backend/reportes/listar/'.$p->id)?>" class="btn btn-primary"><i class="icon-eye-open icon-white"></i> Ver Reportes</a>
            </td>
        </tr>
        <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
