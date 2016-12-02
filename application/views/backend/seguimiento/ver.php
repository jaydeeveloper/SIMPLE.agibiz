<?php if($this->config->item('js_diagram')=='gojs'):?>
<link href="<?= base_url() ?>assets/css/diagrama-procesos2.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/js/go/go.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/diagrama-procesos2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/seguimiento2.js"></script>
<?php else: ?>
<link href="<?= base_url() ?>assets/css/diagrama-procesos.css" rel="stylesheet">
<script src="<?= base_url() ?>assets/js/jquery.jsplumb/jquery.jsPlumb-1.3.16-all-min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/diagrama-procesos.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/seguimiento.js"></script>
<?php endif ?>

<script type="text/javascript">
    $(document).ready(function(){

        <?php
            $conector = 'Bezier';
            $config =Doctrine::getTable('CuentaHasConfig')->findOneByIdparAndCuentaId(2,Cuenta::cuentaSegunDominio()->id);
            if($config){
                $config =Doctrine::getTable('Config')->findOneByIdAndIdpar($config->config_id,$config->idpar);
                $conector = $config->nombre;
            } 
        ?>
        var conector = '<?= $conector; ?>';

        tramiteId=<?= $tramite->id ?>;
        drawFromModel(<?= $tramite->Proceso->getJSONFromModel() ?>,"<?=$tramite->Proceso->width?>","<?=$tramite->Proceso->height?>",conector);
        drawSeguimiento(<?= json_encode($tramite->getTareasActuales()->toArray()) ?>,<?= json_encode($tramite->getTareasCompletadas()->toArray()) ?>, <?= json_encode($tramite->getTareasVencidas()->toArray()) ?>, <?= json_encode($tramite->getTareasVencenHoy()->toArray()) ?>);
    });

	function auditarRetrocesoEtapa(etapaId) {
	    $("#auditar").load(site_url + "backend/seguimiento/ajax_auditar_retroceder_etapa/" + etapaId);
	    $("#auditar").modal();
	    return false;
	}
</script>

<ul class="breadcrumb">
    <li><a href="<?= site_url('backend/seguimiento/index') ?>">Seguimiento de Procesos</a></li> <span class="divider">/</span>
    <li><a href="<?= site_url('backend/seguimiento/index_proceso/'.$tramite->Proceso->id) ?>"><?=$tramite->Proceso->nombre?></a></li> <span class="divider">/</span>
    <li class="active">Trámite # <?= $tramite->id ?></li>
</ul>

<div class="well" style="position:fixed; top: 230px; right: 20px; width: 300px; height: 500px; z-index: 1000; overflow-y: scroll">
    <h3>Registro de eventos</h3>
    <hr />
    <ul>
        <?php foreach ($etapas as $etapa): ?>
            <li>
                <h4><?= $etapa->Tarea->nombre ?></h4>
                <p>Estado: <?= $etapa->pendiente == 0 ? 'Completado' : ($etapa->vencida() ? 'Vencida' :'Pendiente') ?></p>
                <p><?= $etapa->created_at ? 'Inicio: ' . strftime('%c', mysql_to_unix($etapa->created_at)) : '' ?></p>
                <p><?= $etapa->ended_at ? 'Término: ' . strftime('%c', mysql_to_unix($etapa->ended_at)) : '' ?></p>
                <p>Asignado a: <?= !$etapa->usuario_id ? 'Ninguno' : !$etapa->Usuario->registrado ? 'No registrado' : '<abbr class="tt" title="'.$etapa->Usuario->displayInfo().'">'.$etapa->Usuario->displayUsername().'</abbr>' ?></p>
                <p><a href="<?= site_url('backend/seguimiento/ver_etapa/' . $etapa->id) ?>">Revisar detalle</a></p>
                <?php if (!in_array( 'seguimiento',explode(',',UsuarioBackendSesion::usuario()->rol)) && 
				((count($etapa->Tramite->Etapas)>1  && $etapa->pendiente) || $etapa->isFinal())):?>
                <p><a href="#" onclick ="return auditarRetrocesoEtapa(<?php echo $etapa->id; ?>)">Retroceder etapa</a></p>
                <?php endif?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="areaDibujo">
    <h1><?= $tramite->Proceso->nombre ?></h1>
</div>  
<div id="drawWrapper"><div id="draw"></div></div>
</div>

<div id="auditar" class="modal hide fade" >

</div>

