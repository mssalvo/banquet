<?php
namespace Banquet\Model;

/**
 * Generated 30/06/2026 10:34:30
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Model  Corsi
 */

use Banquet\Entity\Corsi;
use Banquet\Dao\CorsiDao;

class CorsiModel extends CorsiDao {
	private $corsi;

	public function __construct(Corsi $corsi) {
		$this->corsi=$corsi;
		parent::__construct($corsi);
	}
}