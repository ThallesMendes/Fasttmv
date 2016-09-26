<?php
namespace Fasttmv\Classes;

# classe para desenvolvimento de telas usando template padr�o
# Thalles Mendes 07/07/2015

class Layout {
	
	public static $instance;
	
	//propiedades para gera��o da tela
	private $titulo;
	private $campos = array();
	private $labels = array();
	
	//contrutor privado - singleton
	private function __construct(){
		
	}
	
	//retorno de instancia - singleton
	public static function getInstance(){
		if(!isset(self::$instance)){
			self::$instance = new Layout();
		}
		return self::$instance;
	}

	public static function topo($titulo){
		
		$topo = '<div class="page-title">' .
				'<div class="title-env">' .
				'<h1 class="title">' . $titulo  . '</h1>' .
				'</div>'.
				'</div>';
		echo $topo;
	}
	
	public static function geraInputs( $campos = array() ){
		try {
			$html 	= '';
			$val  	= '';
			$label 	= '';
			foreach($campos as $c){
				$html = '';
				if($c['tipo'] == 'select'){
					$label = 'label';
					$val   = 'val';
					$select_padrao = '<option value="">Selecione</option>';
					if(isset($c['labels']))
						$label = $c['labels'];
					if(isset($c['val']))
						$val   = $c['val'];
					if(isset($c['empty']))
						$select_padrao = '';
					
					$html = '';
					$html = '<!-- ' . $c['nome'] . ' -->' .
							'<div class="form-group">' .
								'<label class="col-sm-2 control-label">' . $c['label'] . '</label>' .
								'<div class="col-sm-' . $c['tam'] . '">' .
									'<select class="form-control" name="' . $c['nome'] . '" id="' . $c['nome'] . '">' .
										$select_padrao;
										    if(is_array($c['values'])){
												foreach($c['values'] as $values){
											
													$html .= '<option value="' . $values[$val] . '">' . $values[$label] . '</option>';
												}
										    }
									
						  $html .= '</select>' .
								'</div>' .
							'</div>';
					
				}
				else if($c['tipo'] == 'text' || $c['tipo'] == 'password' || $c['tipo'] == 'number' || $c['tipo'] == 'date'){
					$more = '';
					if(isset($c['more']))
						$more = $c['more'];
					$class = '';
					if(isset($c['class']))
						$class = $c['class'];
					
					$html = '<!-- ' . $c['nome'] . ' -->' .
							'<div class="form-group">' .
								'<label class="col-sm-2 control-label" for="' . $c['nome'] . '">' . $c['label'] . '</label>' .
								'<div class="col-sm-' . $c['tam'] . '">' .
									'<input type="' . $c['tipo'] . '" class="form-control ' . $class . '" name="' . $c['nome'] . '" id="' . $c['nome'] . '" placeholder="' . $c['place'] . '" "' . $more . '">' .
								'</div>' .
							'</div>';
				}
				else if ($c['tipo'] == 'hidden'){
					$html = '<!-- ' . $c['nome'] . ' -->' .							
							'<input type="' . $c['tipo'] . '" class="form-control" name="' . $c['nome'] . '" id="' . $c['nome'] . '" value="' . $c['valor'] . '">';
							
				}
				else if($c['tipo'] == 'textarea'){
					$html = '<!-- ' . $c['nome'] . ' -->' .
							'<div class="form-group">' .
							'<label class="col-sm-2 control-label" for="' . $c['nome'] . '">' . $c['label'] . '</label>' .
							'<div class="col-sm-' . $c['tam'] . '">' .
							'<textarea class="form-control" name="' . $c['nome'] . '" id="' . $c['nome'] . '" lines="'. $c['lines'] .'" maxlenght="'. $c['max'] .'" ></textarea>' .
							'</div>' .
							'</div>';
				}
				echo $html;
				
			}
			
		}catch(Exception $e){ echo "Erro ao gerar inputs :" . $e->getMessage(); }
	}
	
	public function geraBtns($btns){
		try {
			$html = '<div class="form-group">';
			foreach($btns as $b){
				if(isset($b['link'])){
					$html .= '<a id="' . $b['nome'] . '"' . 
							    'class="btn btn-'. $b['style'] .' btn-single pull-' . $b['orientacao'] . '">' .$b['label'] . '</a>';
				}
				else
				{
					$html .= '<button type="button" id="' . $b['nome'] . '"' . 
							    'class="btn btn-'. $b['style'] .' btn-single pull-' . $b['orientacao'] . '">' .$b['label'] . '</button>';	
				}
				
			}
			$html .= '</div>';
			echo $html;
			
		}catch(Exception $e){ echo "Erro ao gerar btns : " . $e->getMessage(); }
	}
	
	public static function initForm( $nome, $method, $action="#" ){
		$form = '<div class="panel panel-default">' .
				'<div class="panel-heading">' .
					'<h3 class="panel-title">Preencha os campos corretamente</h3>' .
				'</div>' .
				'<div class="panel-body">' .
				'<form role="form" id="' . $nome . '" class="form-horizontal" role="form" method="' . $method . '" action="' . $action .'">';
		echo $form;
	}
	
	public static function exitForm(){
		echo '</form></div></div>';
	}
	
}