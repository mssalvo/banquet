<?php
namespace Banquet\Entity;

/**
 * Generated 30/06/2026 10:34:30
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Entity  Corsi
 */

class Corsi {

	public $id;
	public $nome;
	public $slug;
	public $descrizione;

	public function __construct($row = NULL)
	{
		if ($row !== NULL) {
			$this->_setCorsi($row);
		}
	}

	public function _setCorsi($row)
	{
		$this->id=isset($row["id"])?$row["id"]:NULL;
		$this->nome=isset($row["nome"])?$row["nome"]:NULL;
		$this->slug=isset($row["slug"])?$row["slug"]:NULL;
		$this->descrizione=isset($row["descrizione"])?$row["descrizione"]:NULL;
	}


	public function setId($id){
		$this->id=$id;
	}

	public function getId(){
		return $this->id;
	}

	public function setNome($nome){
		$this->nome=$nome;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setSlug($slug){
		$this->slug=$slug;
	}

	public function getSlug(){
		return $this->slug;
	}

	public function setDescrizione($descrizione){
		$this->descrizione=$descrizione;
	}

	public function getDescrizione(){
		return $this->descrizione;
	}

	const VAR_CLASSNAME = "Corsi";
	const COLUMN_ID = "id";
	const COLUMN_NOME = "nome";
	const COLUMN_SLUG = "slug";
	const COLUMN_DESCRIZIONE = "descrizione";
}
