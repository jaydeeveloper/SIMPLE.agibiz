<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->input->is_cli_request()) {
            echo 'Accion no permitida';
            exit;
    }
    }
    
    public function hourly(){
        //Indexamos las busquedas en Sphinx
        system('cd sphinx; searchd; indexer --rotate --all');
    }

    public function daily() {             
        //Buscamos las etapas que estan por vencer, pendientes y que requieren ser notificadas
        $etapas = Doctrine_Query::create()
                ->from('Etapa e, e.Tarea t')
                ->where('e.pendiente = 1 AND t.vencimiento_notificar = 1')
                //->andWhere('DATEDIFF(e.vencimiento_at,NOW()) <= t.vencimiento_notificar_dias')
                ->execute();
        foreach ($etapas as $e) {
            $vencimiento=$e->vencimiento_at;
            if($vencimiento!=''){
                $dias_por_vencer=ceil((strtotime($e->vencimiento_at)-time())/60/60/24);
                $dias_no_habiles = 0;
                if ($e->Tarea->vencimiento_habiles == 1)
                    $dias_no_habiles = get_working_days_count(date('Y-m-d'), $e->vencimiento_at);
                $regla=new Regla($e->Tarea->vencimiento_notificar_email);
                $email=$regla->getExpresionParaOutput($e->id);
                
                if ($dias_por_vencer > 0)
                    $dias_por_vencer-=$dias_no_habiles;
                
                if ($dias_por_vencer <= $e->Tarea->vencimiento_notificar_dias){
                    echo 'Enviando correo de notificacion para etapa ' . $e->id . "\n";
                    $varurl = site_url('etapas/ejecutar/' .$e->id);
                    $varurl = str_replace("..", ".", $varurl);


                    $cuenta=$e->Tramite->Proceso->Cuenta; 
                    $this->email->from($cuenta->nombre.'@'.$this->config->item('main_domain'), $cuenta->nombre_largo);
                    $this->email->to($email);
                    $this->email->subject('Etapa se encuentra ' . ($dias_por_vencer>0 ?'por vencer':'vencida'));
                    $this->email->message('<p>La etapa "' . $e->Tarea->nombre . '" del proceso "'.$e->Tramite->Proceso->nombre.'" se encuentra '
                            .($dias_por_vencer>0?'a '.$dias_por_vencer. (abs($dias_por_vencer)==1?' día ':' días ') .($e->Tarea->vencimiento_habiles == 1 ? 'habiles ' : '') .
                                    'por vencer':('vencida '.($dias_por_vencer<0 ? 'hace '.abs($dias_por_vencer).(abs($dias_por_vencer)==1?' día ':' días ') : 'hoy'))).' ('.date('d/m/Y',strtotime($e->vencimiento_at)).').' . "</p><br>" . 
                            '<p>Usuario asignado: ' . $e->Usuario->usuario .'</p>'.($dias_por_vencer > 0 ? '<p>Para realizar la etapa, hacer click en el siguiente link: '. $varurl .'</p>':''));
                    $this->email->send();
                }
            
            }
        }


        //Hacemos un respaldo de la base de datos
        //$this->load->database();
        //$backupName = $this->db->database . '_' . date("Ymd-His") . '.gz';
        //$command = 'mysqldump -h '.$this->db->hostname.' -u '.$this->db->username.' -p'.$this->db->password.' '.$this->db->database.' | gzip > '.$backupName;
        //system($command);
        //$this->load->library('s3wrapper');
        //$this->s3wrapper->putObject($this->s3wrapper->inputFile($backupName, false), 'senatics.gov.py', $backupName);   
        //system('rm ' . $backupName);
        
        //Limpia los tramites que que llevan mas de 1 dia sin modificarse, sin avanzar de etapa y sin datos ingresados (En blanco).
        $tramites_en_blanco=Doctrine_Query::create()
                ->from('Tramite t, t.Etapas e, e.Usuario u, e.DatosSeguimiento d')
                ->where('t.updated_at < DATE_SUB(NOW(),INTERVAL 1 DAY) AND t.pendiente = 1')
                ->groupBy('t.id')
                ->having('COUNT(e.id) = 1 AND COUNT(d.id) = 0')
                ->execute();
        $tramites_en_blanco->delete();

        //Limpia los tramites que han sido iniciados por usuarios no registrados, y que llevan mas de 1 dia sin modificarse, y sin avanzar de etapa.
        $tramites_en_primera_etapa=Doctrine_Query::create()
                ->from('Tramite t, t.Etapas e, e.Usuario u')
                ->where('t.updated_at < DATE_SUB(NOW(),INTERVAL 1 DAY) AND t.pendiente = 1')
                ->groupBy('t.id')
                ->having('COUNT(e.id) = 1')
                ->execute();
        foreach($tramites_en_primera_etapa as $t)
            if($t->Etapas[0]->Usuario->registrado == 0)
                $t->delete();

        //Elimino los registros no registrados con mas de 1 dia de antiguedad y que no hayan iniciado etapas
        $noregistrados=Doctrine_Query::create()
                ->from('Usuario u, u.Etapas e')
                ->where('u.registrado = 0 AND DATEDIFF(NOW(),u.updated_at) >= 1')
                ->groupBy('u.id')
                ->having('COUNT(e.id) = 0')
                ->execute();     
        $noregistrados->delete();   
    }
    
    }
