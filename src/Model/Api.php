<?php
namespace App\Model;

class Api 
{
	/**
	 * Responsável por processar a requisição com filtro e ordenação
	 * 
	 * @param unknown $data
	 * @param unknown $filtro
	 * @param unknown $valor
	 * @param unknown $ordem
	 * @return mixed
	 */
	public function search($data, $filtro, $valor, $ordem = "desc"){
		switch($filtro){
			case "salario":
				$ret = $this->getDataBySalario($data, $valor);
				break;
			case "cidade":
				$ret = $this->getDataByCidade($data, $valor);
				break;
			case "texto":
			default:
				$ret = $this->getDataByText($data, $valor);
				break;
		}
		
		//Realiza a ordenação conforme parametro passado
		$ret_data = $this->ordenaSalario($ret, $ordem);
		
		return $ret_data;
	}
	
   	/**
   	 * Retorna dados de um JSON decodificados para tratamento
   	 * 
   	 * @param string $path_json
   	 * @return mixed
   	 */
   	public function getDataJson( $path_json ){
   		$data = file_get_contents( $path_json );
   		
   		$data = json_decode($data, true);

   		return $data["docs"];
   	}
   	
   	/**
   	 * Filtra por um texto passado por parâmetro
   	 * 
   	 * @param unknown $data
   	 * @param unknown $text
   	 * @return mixed
   	 */
   	private function getDataByText( $data, $text ){
   	
   		$text = strtolower($this->removeAcentos($text));
   		
   		$retorno = array();
   		foreach($data as $vaga){
   			
   			$title = strtolower($this->removeAcentos($vaga['title']));
   			$desc  = strtolower($this->removeAcentos($vaga['description']));
   			
   			if ( strpos($title, $text) !== false || strpos($desc, $text) !== false ){
   				$retorno[] = $vaga;
   			}
   				
   		}
   		return $retorno;
   	}
   	
   	/**
   	 * Filtra pelo salario passado por parâmetro
   	 * 
   	 * @param unknown $data
   	 * @param unknown $salario
   	 * @param unknown $minmax | (min ou max)
   	 * @return mixed
   	 */   	 
   	private function getDataBySalario( $data, $salario, $minmax = "min" ){
   		   	   		
   		$retorno = array();
   		foreach($data as $vaga){
   			
   			if($minmax == "max"){
   				//Valor Máximo
	   			if ($vaga['salario'] <= $salario){
	   				$retorno[] = $vaga;
	   			}
   			}else{
   				//Valor Mínimo
   				if ($vaga['salario'] >= $salario){
   					$retorno[] = $vaga;
   				}
   			}
   		}
   		return $retorno;
   	}
   	
   	/**
   	 *
   	 * @param unknown $data
   	 * @param unknown $text
   	 */
   	private function getDataByCidade( $data, $cidade ){
   		$cidade = strtolower(trim($this->removeAcentos($cidade)));
   		
   		$retorno = array();
   		foreach($data as $vaga){   			
   			if ( strpos(strtolower(trim($this->removeAcentos($vaga['cidade'][0]))), $cidade) !== false){
   				$retorno[] = $vaga;
   			}
   		}
   		
   		return $retorno;
   	}

   	/**
   	 * Realiza Ordenação pelo sálario (asc e desc)
   	 * 
   	 * @param array $arrayData
   	 * @param string $ordem | (asc e desc)
   	 * @return array
   	 */
   	private function ordenaSalario( $arrayData, $ordem = "asc" ){ 
	   	
	   	switch($ordem){
	   		case 'des':
	   			usort($arrayData, function($a, $b) {
	   				return ($a['salario'] > $b['salario'] ? -1 : 1);
	   			});
	   				break;
	   		case 'asc':
	   			usort($arrayData, function($a, $b) {
	   				return ($a['salario'] < $b['salario'] ? -1 : 1);
	   			});
	   				break;
	   	}
	   	
	   	return $arrayData;
	}

   	/**
   	 * Função para remover acentos de uma string
	 *
   	 * @param unknown $string
   	 * @param string $slug
   	 * @return mixed
   	 */	
   	 private function removeAcentos($string, $slug = false) {
		$string = mb_strtolower(utf8_decode($string));
	
		// Código ASCII das vogais
		$ascii['a'] = range(224, 230);
		$ascii['e'] = range(232, 235);
		$ascii['i'] = range(236, 239);
		$ascii['o'] = array_merge(range(242, 246), array(240, 248));
		$ascii['u'] = range(249, 252);
		// Código ASCII dos outros caracteres
		$ascii['b'] = array(223);
		$ascii['c'] = array(231);
		$ascii['d'] = array(208);
		$ascii['n'] = array(241);
		$ascii['y'] = array(253, 255);
		
		foreach ($ascii as $key=>$item) {
			$acentos = '';
			foreach ($item AS $codigo){
				$acentos .= chr($codigo);
			}				
			$troca[$key] = '/['.$acentos.']/i';
		}
		
		$string = preg_replace(array_values($troca), array_keys($troca), $string);
		// Slug?
		if ($slug) {
			// Troca tudo que não for letra ou número por um caractere ($slug)
			$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
			// Tira os caracteres ($slug) repetidos
			$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
			$string = trim($string, $slug);
		}
		
		return $string;
	}
}