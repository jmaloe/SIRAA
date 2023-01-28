<?php
require_once('CCategoriaRequisito.php');

class CRequisito extends CCategoriaRequisito{

	var $id_reg_requisito, $id_tipreq, $cns_regActividades;
	var $label, $l_class;
	var $input_type, $id_input, $id_input_class, $id_input_placeholder;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }
 /*Setters*/
	function setIdTipoRequisito($id_tr){
		$this->id_tipreq = $id_tr;
	}

	function setRegActividades($reg){
 		$this->cns_regActividades = $reg;
 	}

	function setLabel($l){
		$this->label = $l;
	}

	function setLabelClass($lc){
		$this->l_class = $lc;
	}

	function setInputType($it)
	{
		$this->input_type = $it;
	}

	function setIdInput($id_i){
		$this->id_input = $id_i;
	}

	function setInputClass($id_ic){
		$this->id_input_class = $id_ic;
	}

	function setInputPlaceholder($id_ip){
		$this->id_input_placeholder = $id_ip;
	}
/*Getters*/
	function getIdTipoRequisito(){
		return $this->id_tipreq;
	}

	function getLabel(){
		return $this->label;
	}

	function getLabelClass(){
		return $this->l_class;
	}

	function getInputType()
	{
		return $this->input_type;
	}

	function getIdInput(){
		return $this->id_input;
	}

	function getInputClass(){
		return $this->id_input_class;
	}

	function getInputPlaceholder(){
		return $this->id_input_placeholder;
	}

	function getRequisitoByIdInput($input_name, $id_actividad){
		$sql='SELECT drq.valor FROM detalle_registro_requisitos drq, registro_requisitos rr, tipo_requisito tr WHERE drq.id_regRequisito=rr.id_regRequisito AND drq.id_tipreq=tr.id_tipreq AND rr.cns_regActividades='.$id_actividad.' AND tr.id_input=\''.$input_name.'\' ORDER BY tr.id_tipreq;';
         $resultado = $this->query($sql);
         $data = mysqli_fetch_row($resultado);
       return $data[0];
	}

	function getAllTipoRequisito(){
	   $sql="SELECT c.id_cat_req, c.descripcion, t.id_tipreq, t.label, t.l_class, t.input, t.id_input, t.id_input_class, t.id_input_placeholder FROM categoria_requisito c, tipo_requisito t WHERE c.id_cat_req=t.id_cat_req ORDER BY c.id_cat_req, t.id_tipreq;";
         $resultado = $this->query($sql);
         $data = $this->getReqItems($resultado);
       return $data;
	}

	function getRequisitosByCategoria($categoria){
	   $sql='SELECT c.id_cat_req, c.descripcion, t.id_tipreq, t.label, t.l_class, t.input, t.id_input, t.id_input_class, t.id_input_placeholder FROM categoria_requisito c, tipo_requisito t WHERE c.id_cat_req=t.id_cat_req AND c.id_cat_req='.$categoria.' ORDER BY c.id_cat_req, t.id_tipreq;';
         $resultado = $this->query($sql);
         $data = $this->getReqItems($resultado);
       return $data;
	}

	function getRequisitosByIdRegActs($id_actividad, $forUpdate){
		$sql='SELECT tr.id_input, tr.label, drq.valor FROM detalle_registro_requisitos drq, registro_requisitos rr, tipo_requisito tr WHERE drq.id_regRequisito=rr.id_regRequisito AND drq.id_tipreq=tr.id_tipreq AND rr.cns_regActividades='.$id_actividad.' ORDER BY tr.id_tipreq;';
         $resultado = $this->query($sql);
         $elementos = array();
         if($resultado){
         	while($datos = mysqli_fetch_assoc($resultado)){
         		if($forUpdate)         			
         			array_push($elementos,array($datos['id_input']=>$datos['valor']));         		
         		else
         			array_push($elementos,array(0=>$datos['label'],1=>$datos['valor']));
         	}
         	return $elementos;
         }
       return false;
	}

	function addRegistroRequisitos(){
		$sql = "INSERT INTO registro_requisitos(cns_regActividades) VALUES(".$this->cns_regActividades.")";
 	 	$this->query($sql);
 	 	$this->id_reg_requisito = $this->getInsertId();
	}

	function addDetalleRegRequisitos($requisito, $valor){
		$sql = "SELECT id_tipreq,label FROM tipo_requisito WHERE id_input='".$requisito."';";
 	 	$resultado = $this->query($sql);
 	 	if($datos = mysqli_fetch_assoc($resultado)){
 	 		$sql = "INSERT INTO detalle_registro_requisitos(id_regRequisito, id_tipreq, valor) VALUES(".$this->id_reg_requisito.",".$datos['id_tipreq'].",'".$this->scapeString($valor)."');";
 	 		if($this->query($sql))
 	 			return '<label>'.$datos['label']."</label><br>".$valor."<br>";
 	 		else
 	 			return $this->getError();
 	 	}
	}

	function eliminarRequisitos(){
		$sql = "DELETE rr, drr FROM registro_requisitos rr JOIN detalle_registro_requisitos drr ON drr.id_regRequisito=rr.id_regRequisito WHERE rr.cns_regActividades=".$this->cns_regActividades;
		if(!$this->update($sql)){
         echo $this->getError();
   		}
	}
}
?>