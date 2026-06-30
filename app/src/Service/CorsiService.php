<?php
namespace Banquet\Service;

/**
 * Generated 30/06/2026 10:34:30
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Service  Corsi
 */

use Banquet\Entity\Corsi;
use Banquet\Model\CorsiModel;

class CorsiService {
	private $model;

	public function __construct(CorsiModel $model) {
		$this->model=$model;
	}

	public function salva(Corsi $corsi){
		$this->model->setCorsi($corsi);
		$this->model->save();
	}

	public function update(Corsi $corsi){
		$this->model->setCorsi($corsi);
		$this->model->update();
	}

	public function delete(Corsi $corsi){
		$this->model->setCorsi($corsi);
		$this->model->delete();
	}

	public function getAllCorsi(){
		return $this->model->getAllObject();
	}

	public function getCorsiById($id){
		return $this->model->getObject($id);
	}

	public function getLastInsertId() {
		return $this->model->getLastInsertId();
	}

}