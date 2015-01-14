<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

class MongoValidation {
	static $Type = array('varchar','int','onlyAlpha','onlyAlphanumeric','date','email','tell','cnpj','cpf','money','url');
	public $varchar;
	public $format = "DD/MM/YYYY";
	
	const ERRORINT = "Erro! Apenas Números inteiros!";
	const ERRORALPHA = "Erro! Apenas letras!";
	const ERRORALPHANUM = "Erro! Apenas letras e números";
	const ERRORDATE = "Erro! Data inválida!";
	const ERRORMAIL = "Erro! E-mail inválido!";
	const ERRORURL = "Erro! URL inválido!";
	const ERRORTELL = "Erro! Telefone inválido!";
	const ERRORCNPJ = "Erro! CPNJ inválido!";
	const ERRORCPF = "Erro! CPF Inválido!";
	const ERRORMONEY = "Erro! Valor Inválido!";
	
	
	public function Valid($Sting,$Tipo = 'varchar',$error = "error"){
		if (!in_array($Tipo,MongoValidation::$Type)){
			$Type = "varchar";
		}
		$Method = "_".$Tipo;
		if (method_exists($this,$Method)){
			$this->varchar = $this->$Method($Sting);
		}
		return $this->varchar;
	}
	
	public function _varchar($str){
		return $str;
	}
	
	public function _int($str){
		if (empty($str) || filter_var($str,FILTER_VALIDATE_INT)){
			return $str;
		}
	}
	
	public function _onlyAlpha($str){
		if (empty($str) || ctype_alpha($str)) {
			return $str;
		}
		return false;
	}
	
	public function _onlyAlphanumeric($str){
		if (empty($str) || ctype_alnum($str)) {
			return $str;
		}
		return false;
	}
	
	public function _date($date){
		switch($this->format){
            case 'YYYY/MM/DD':
            case 'YYYY-MM-DD':
            list( $y, $m, $d ) = preg_split( '/[-\.\/ ]/', $date );
            break;

            case 'YYYY/DD/MM':
            case 'YYYY-DD-MM':
            list( $y, $d, $m ) = preg_split( '/[-\.\/ ]/', $date );
            break;

            case 'DD-MM-YYYY':
            case 'DD/MM/YYYY':
            list( $d, $m, $y ) = preg_split( '/[-\.\/ ]/', $date );
            break;
			
            case 'MM-DD-YYYY':
            case 'MM/DD/YYYY':
            list( $m, $d, $y ) = preg_split( '/[-\.\/ ]/', $date );
            break;
			
            case 'YYYYMMDD':
            $y = substr( $date, 0, 4 );
            $m = substr( $date, 4, 2 );
            $d = substr( $date, 6, 2 );
            break;
			
            case 'YYYYDDMM':
            $y = substr( $date, 0, 4 );
            $d = substr( $date, 4, 2 );
            $m = substr( $date, 6, 2 );
            break;
			
            default:
            return false;
        }
		if (checkdate( $m, $d, $y )){
			return $date;
		}
		return false;
	}
	
	public function _email($value) {
		if (filter_var($value, FILTER_VALIDATE_EMAIL)){
			return $value;
		}
		return false;
	}
	
	public function _url($value) {
		if (filter_var($value, FILTER_VALIDATE_URL)){
			return $value;
		}
		return false;
	}
	
	public function _cpf($value) {
		if ($this->validaCPF($value)){
			return $value;
		}
		return false;
	}
	
	public function _cnpj($value) {
		if ($this->validaCNPJ($value)){
			return $value;
		}
		return false;
	}
	
	public function _money($value){
		$a = preg_match("/\b\d{1,3}(?:,?\d{3})*(?:\.\d{2})?\b/", $value, $From);
		if (isset($From[0])){
			return $From[0];
		}
		return false;
	}
	
	public function _tell($value){
		$search = preg_match('/^[(][0-9]{2}[)][ ][0-9]{4}[-][0-9]{4,5}$/',$valor,$result);
		if (isset($result[0])){
			return $result[0];
		}
		return false;
	}
	
	public function validaCPF($cpf) {
		$cpf = str_pad(preg_replace('/[^0-9_]/', '', $cpf), 11, '0', STR_PAD_LEFT);
		if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
			return false;
		} else {
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
			return true;
		}
	}
	
	public function validaCNPJ($cnpj) {
		if (strlen($cnpj) <> 18)
			return 0;
		$soma1   = ($cnpj[0] * 5) + ($cnpj[1] * 4) + ($cnpj[3] * 3) + ($cnpj[4] * 2) + ($cnpj[5] * 9) + ($cnpj[7] * 8) + ($cnpj[8] * 7) + ($cnpj[9] * 6) + ($cnpj[11] * 5) + ($cnpj[12] * 4) + ($cnpj[13] * 3) + ($cnpj[14] * 2);
		$resto   = $soma1 % 11;
		$digito1 = $resto < 2 ? 0 : 11 - $resto;
		$soma2   = ($cnpj[0] * 6) + ($cnpj[1] * 5) + ($cnpj[3] * 4) + ($cnpj[4] * 3) + ($cnpj[5] * 2) + ($cnpj[7] * 9) + ($cnpj[8] * 8) + ($cnpj[9] * 7) + ($cnpj[11] * 6) + ($cnpj[12] * 5) + ($cnpj[13] * 4) + ($cnpj[14] * 3) + ($cnpj[16] * 2);
		$resto   = $soma2 % 11;
		$digito2 = $resto < 2 ? 0 : 11 - $resto;
		return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
	}
	
}

?>