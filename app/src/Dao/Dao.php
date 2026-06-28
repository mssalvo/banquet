<?php
 
/**
 * Generated 28/06/2026 17:01:08
 * Auto-generated tools banquet (https://github.com/mssalvo/banquet)
 * @author Salvatore Mariniello
 * @copyright MIT
 */
 
namespace Banquet\Dao;

use Banquet\Driver\PDODriver;


abstract class Dao {

    abstract protected function save();
    
    abstract protected function update();

    abstract protected function delete();
  
    abstract protected function getObject($id);
    
    abstract protected function getAllObject();
    
    abstract protected function getFindAll();

    abstract protected function getFind($id);

    protected function getDriver(): PDODriver
    {
        return PDODriver::getDriver();
    }

    protected function query(string $sql, array $params = [])
    {
        return $this->getDriver()->query($sql, $params);
    }

    protected function fetchRow(string $sql, array $params = [])
    {
        return $this->getDriver()->fetchRow($sql, $params);
    }

    protected function fetchAll(string $sql, array $params = [])
    {
        return $this->getDriver()->fetchAll($sql, $params);
    }

    protected function lastInsertId()
    {
        return $this->getDriver()->lastInsertId();
    }

    
    public function report_find_xml($id) {

        return $this->define_report_xml($this->getFind($id));
    }

    public function report_find_json($id) {

        return $this->define_report_json($this->getFind($id));
    }

    public function report_all_xml() {

        return $this->define_report_xml($this->getFindAll());
    }

    public function report_all_json() {

        return $this->define_report_json($this->getFindAll());
    }

    public function report_find_html_table($id) {

        return $this->define_report_html_table($this->getFind($id));
    }

    public function report_html_table() {

        return $this->define_report_html_table($this->getFindAll());
    }

    public function report_html_select($propertyObject) {

        return $this->define_report_html_select($this->getFindAll(), $propertyObject);
    }

    protected function define_report_xml($rows) {

        return util_report_xml($rows);
    }

    protected function define_report_json($rows) {

        return util_report_json($rows);
    }

    protected function define_report_html_table($rows) {

        return util_report_html_table($rows);
    }

    protected function define_report_html_select($rows, $property) {

        return util_report_html_select($rows, $property);
    }


}

?>
