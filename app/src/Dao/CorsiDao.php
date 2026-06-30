<?php
namespace Banquet\Dao;

/**
 * Generated 30/06/2026 10:34:30
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @copyright MIT
 * Dao  Corsi
 */

use Banquet\Entity\Corsi;
use Banquet\Dao\Dao;

class CorsiDao extends Dao {
	private $corsi;

	public function __construct(Corsi $corsi) {
		$this->corsi=$corsi;
	}

	public function setCorsi(Corsi $corsi) {
		$this->corsi=$corsi;
	}

	public function save() {
		$sql = "INSERT INTO corsi
			(id,
				nome,
				slug,
				descrizione)
			 VALUES
			(?,?,?,?);";

		$this->query($sql,[$this->corsi->id,$this->corsi->nome,$this->corsi->slug,$this->corsi->descrizione]);

		return true;
	}

	public function update() {
		$sql = "UPDATE corsi
			SET
				id = ?,
				nome = ?,
				slug = ?,
				descrizione = ?
			 WHERE
			id = ?;";

		$this->query($sql,[$this->corsi->id,$this->corsi->nome,$this->corsi->slug,$this->corsi->descrizione,$this->corsi->id]);

		return true;
	}

	public function delete() {
		$sql = "DELETE FROM corsi WHERE id = ?;";
		$this->query($sql,[$this->corsi->id]);

		return true;
	}

	public function getFind($id) {
		$sql = "SELECT * FROM corsi WHERE id = ?;";
		$result = $this->fetchRow($sql, [$id]);

		if ($result && is_array($result)) {
			return $result;
		}

		return [];
	}

	public function getFindAll() {
		$sql = "SELECT * FROM corsi";
		$result = $this->fetchAll($sql);

		if ($result && is_array($result)) {
			return $result;
		}

		return [];
	}

	public function getAllObject() {
		$sql = "SELECT * FROM corsi";
		$rows = $this->fetchAll($sql);

		if (is_array($rows)) {
			return array_map(function ($row) {
				return new Corsi($row);
			}, $rows);
		}

		return null;
	}

	public function getObject($id) {
		$sql = "SELECT * FROM corsi WHERE id = ?;";
		$rows = $this->fetchRow($sql, [$id]);

		if (is_array($rows)) {
			return new Corsi($rows);
		}

		return null;
	}

	public function getLastInsertId() {
		return $this->lastInsertId();
	}

}
