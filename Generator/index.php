<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

require_once('../Mongo/Mongo.php');
	if (isset($_POST['Send'])){
		$_POST['coluna'] = array_unique($_POST['coluna']);
		if (isset($_POST['collection']{3})){
			$Name = $GLOBALS['MongoSettings']['ModelBase'].$_POST['collection'];
		}else{
			$error = "Collection com no mínimo 3 caracteres";
		}
		
		foreach ($_POST['coluna'] as $k=>$Value){
			if (!isset($Value{0})){
				unset($_POST['coluna'][$k]);
			}
		}
		
		if (count($_POST['coluna']) <= 0){
			$error = "Insira ao menos uma coluna!";
		}
		
		$Valida = '	public function SetValidation() {'."\n";
		foreach ($_POST['valida'] as $k=>$Value){
			if (!empty($Value)){
				$Valida .= '		$this->hasValid("'.$_POST['coluna'][$k].'","'.$Value.'");'."\n";
			}
		}
		$Valida .= '	}'."\n\n";
		
		$Index = '	public function SetIndex() {'."\n";
		foreach ($_POST['index'] as $k=>$Value){
			if (!empty($Value)){
				$Index .= '		$this->hasIndex("'.$_POST['coluna'][$k].'","'.$Value.'");'."\n";
			}
		}
		$Index .= '	}'."\n\n";
		
		$Many = '	public function SetMany() {'."\n";
		foreach ($_POST['many'] as $k=>$Value){
			if (!empty($Value)){
				$Many .= '		$this->hasMany("'.$Value.'","'.$_POST['manyParam'][$k].'");'."\n";
			}
		}
		$Many .= '	}'."\n\n";
		
		if (!isset($error)){
/*
	Generator MongoRones 1.0
	Author: Maicon
	Site: http::/maikweb.com.br
*/
			$Line = '<?php'."\n";
			$Line .= '/*'."\n";
			$Line .= '	Generator MongoRones 1.0'."\n";
			$Line .= '	Author: Maicon'."\n";
			$Line .= '	Site: http::/maikweb.com.br'."\n";
			$Line .= '*/'."\n\n";
			$Line .= 'class '.$Name.' extends MongoTable {'."\n";
			$Line .= '	public $id;'."\n";
			foreach ($_POST['coluna'] as $k=>$Value){
				$Line .= '	public $'.$Value.';'."\n";
			}
			$Line .= '	public $_Extras;'."\n";
			$Line .= "\n".$Valida.$Index;
			$Line .= "\n".'}'."\n\n".'?>';
			
			file_put_contents($GLOBALS['MongoSettings']['PatchModel'].$Name.'.php', $Line);	
			$sucess = "Modelo gerado com sucesso!";		
			
			require_once($GLOBALS['MongoSettings']['PatchModel'].$Name.'.php');
			$Road = new $Name();
			$Road->SetIndex();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<title> Gerar Modelos MongoDB </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css"  href="css/smart-forms.css">
    <link rel="stylesheet" type="text/css"  href="css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>  
    <!--[if lte IE 9]> 
        <script type="text/javascript" src="js/jquery.placeholder.min.js"></script>
    <![endif]-->    
    
    <!--[if lte IE 8]>
        <link type="text/css" rel="stylesheet" href="css/smart-forms-ie8.css">
    <![endif]-->
    <script type="application/javascript">
		var html = '<div class="frm-row"><div class="section colm colm4"><div class="smart-widget sm-left sml-120"><label class="field"><input type="text"name="coluna[]"id="sm"class="gui-input"placeholder="Definir Nome"></label><label for="sm"class="button">Coluna</label></div></div><div class="section colm colm4"><label class="field select"><select name="valida[]"><option value="">Validação</option><option value="int">INT</option><option value="varchar">TEXTO</option><option value="onlyAlpha">ALFABETICOS</option><option value="onlyAlphanumeric">ALFANUMERICOS</option><option value="date">DATA</option><option value="email">EMAIL</option><option value="tell">TELEFONE</option><option value="cpf">CPF</option><option value="cnpj">CNPJ</option></select><i class="arrow"></i></label></div><div class="section colm colm4"><label class="field select"><select name="index[]"><option value="">Selecionar Index</option><option value="unique">unique</option><option value="dropDups">dropDups</option><option value="sparse">sparse</option></select><i class="arrow"></i></label></div></div>';
		var html2 = '<div class="frm-row"><div class="section colm colm6"><div class="smart-widget sm-left sml-120"><label class="field"><input type="text"name="many[]"id="sm"class="gui-input"placeholder="Collection relacionada"value=""></label><label for="sm"class="button">Relação</label></div></div><div class="section colm colm6"><div class="smart-widget sm-left sml-120"><label class="field"><input type="text"name="mmanyParam[]"id="sm"class="gui-input"placeholder="Coluna relacionada"value=""></label><label for="sm"class="button">Coluna</label></div></div></div>';
		function addColuna(){
			$(html).appendTo($(".form-body"));
		}
		
		function addRel(){
			$(html2).appendTo($("#Rell"));
		}
		
	</script>
</head>

<body class="woodbg">

	<div class="smart-wrap">
    	<div class="smart-forms smart-container wrap-0">
        
        	<div class="form-header header-primary">
            	<h4><i class="fa fa-flask"></i>Gerar Modelos MongoDB</h4>
            </div><!-- end .form-header section -->
   	    
        	           
            <form method="post" action="#" id="form-ui">
            	<div class="form-body">
                	<?php if (isset($error)) {?>    
                        <div class="notification alert-error spacer-t10">
                            <p><?=$error?></p>
                            <a href="javascript:;" class="close-btn">×</a>                                  
                        </div><br /><br />
                    <?php } ?>  
                    <?php if (isset($sucess)) {?>    
                        <div class="notification alert-success spacer-t10">
                            <p><?=$sucess?></p>
                            <a href="javascript:;" class="close-btn">×</a>                                  
                        </div><br /><br />
                    <?php } ?> 
                	
                    <div class="spacer-b30">
                    	<div class="tagline"><span> Definir Collection </span></div><!-- .tagline -->
                    </div>
                    
                    <div class="section">
                        <div class="smart-widget sm-left sml-120">
                            <label class="field">
                                <input type="text" name="collection" id="sm" class="gui-input" placeholder="Definir Nome" value="<?=$_POST['collection']?>">
                            </label>
                            <label for="sm" class="button"> Collection </label>
                        </div><!-- end .smart-widget section -->
                    </div><!-- end section -->
					
                    <div class="frm-row">
                    	<div class="section colm colm6">
                            <div class="smart-widget sm-left sml-120">
                                <label class="field">
                                    <input type="text" name="many[]" id="sm" class="gui-input" placeholder="Collection relacionada" value="<?=$Value?>">
                                </label>
                                <label for="sm" class="button"> Relação </label>
                            </div>
                        </div>
                        <div class="section colm colm6">
                            <div class="smart-widget sm-left sml-120">
                                <label class="field">
                                    <input type="text" name="mmanyParam[]" id="sm" class="gui-input" placeholder="Coluna relacionada" value="<?=$Value?>">
                                </label>
                                <label for="sm" class="button"> Coluna </label>
                            </div>
                        </div>
                    </div>
                    <div id="Rell">
                    
                    </div>
                    <br>
                   	<button type="button" class="button btn-primary" onClick="addRel()">Adicionar Relação</button>
                    
                    
                    <div class="spacer-t40 spacer-b40">
                    	<div class="tagline"><span> Definir Colunas </span></div><!-- .tagline -->
                    </div>                                          
                    
                    <div class="frm-row">
                    
                    	<div class="section colm colm4">
                            <div class="smart-widget sm-left sml-120">
                            	<label class="field">
                                	<input type="text" name="coluna[]" id="sm" class="gui-input" placeholder="Definir Nome" value="<?=$_POST['coluna'][0]?>">
                                </label>
                                <label for="sm" class="button"> Coluna </label>
                            </div>
                        </div>
                        <div class="section colm colm4">
                            <label class="field select">
                                <select name="valida[]">
                                    <option value="varchar">Validação</option>
                                    <option value="int">INT</option>
                                    <option value="varchar">TEXTO</option>
                                    <option value="onlyAlpha">ALFABETICOS</option>
                                    <option value="onlyAlphanumeric">ALFANUMERICOS</option>
                                    <option value="date">DATA</option>
                                    <option value="email">EMAIL</option>
                                    <option value="url">URL</option>
                                    <option value="tell">TELEFONE</option>
                                    <option value="cpf">CPF</option>
                                    <option value="cnpj">CNPJ</option>
                                    <option value="money">MOEDA</option>
                                </select>
                                <i class="arrow"></i>                    
                            </label>  
                        </div>
                        <div class="section colm colm4">
                            <label class="field select">
                                <select name="index[]">
                                    <option value="">Selecionar Index</option>
                                    <option value="unique">unique</option>
                                    <option value="dropDups">dropDups</option>
                                    <option value="sparse">sparse</option>
                                </select>
                                <i class="arrow"></i>                    
                            </label>  
                        </div>
                        
                    </div>
                    
   					<?php 
					unset($_POST['coluna'][0]);
					if (is_array($_POST['coluna']))
					foreach ($_POST['coluna'] as $Value) { ?>
                    <div class="frm-row">
                    
                    	<div class="section colm colm4">
                            <div class="smart-widget sm-left sml-120">
                            	<label class="field">
                                	<input type="text" name="coluna[]" id="sm" class="gui-input" placeholder="Definir Nome" value="<?=$Value?>">
                                </label>
                                <label for="sm" class="button"> Coluna </label>
                            </div>
                        </div>
                        <div class="section colm colm4">
                            <label class="field select">
                                <select name="valida[]">
                                    <option value="">Validação</option>
                                    <option value="int">INT</option>
                                    <option value="varchar">TEXTO</option>
                                    <option value="onlyAlpha">ALFABETICOS</option>
                                    <option value="onlyAlphanumeric">ALFANUMERICOS</option>
                                    <option value="date">DATA</option>
                                    <option value="email">EMAIL</option>
                                    <option value="tell">TELEFONE</option>
                                    <option value="cpf">CPF</option>
                                    <option value="cnpj">CNPJ</option>
                                </select>
                                <i class="arrow"></i>                    
                            </label>  
                        </div>
                        <div class="section colm colm4">
                            <label class="field select">
                                <select name="index[]">
                                    <option value="">Selecionar Index</option>
                                    <option value="unique">unique</option>
                                    <option value="dropDups">dropDups</option>
                                    <option value="sparse">sparse</option>
                                </select>
                                <i class="arrow"></i>                    
                            </label>  
                        </div>
                        
                    </div>
                    
                    <?php } ?>
                </div><!-- end .form-body section -->
                <div class="form-footer">
                	<button type="button" class="button btn-primary" onClick="addColuna()">Adicionar Coluna</button>
                	<button type="submit" name="Send" class="button btn-primary">Gerar Modelo</button>
                </div><!-- end .form-footer section -->
            </form>
            
        </div><!-- end .smart-forms section -->
    </div><!-- end .smart-wrap section -->
    
    <div></div><!-- end section -->

</body>
