<?php

   function util_report_xml($rows) {

        $xml_ = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
        $xml_ .= "<data>";

        if ($rows == NULL) {
            return NULL;
        } else {

            foreach ($rows as $row) {
                $xml_ .= "<row>";
                if (is_array($row)) {
                    foreach ($row as $tKey => $tValue) {
                        if (is_string($tKey)) {
                            $xml_ .= "<" . strtolower($tKey) . ">" . str_replace(array("\r\n", "\n", "\r", "\t", "'", "&"), "", $tValue) . "</" . strtolower($tKey) . ">";
                        }
                    }
                }
                $xml_ .= "</row>";
            }
        }
        $xml_ .= "</data>";

        return $xml_;
    }

     function util_report_json($rows) {

        $json_ = NULL;

        if ($rows == NULL) {
            return NULL;
        } else {
            $json_ = array();

            foreach ($rows as $row) {

                if (is_array($row)) {
                    foreach ($row as $tKey => $tValue) {
                        if (is_string($tKey)) {
                            $make_array[strtolower($tKey)] = $tValue;
                        }
                    }
                    $json_[] = $make_array;
                } else {
                    $json_[] = $rows;
                }
            }
        }

        return json_encode($json_);
    }

    function util_report_html_table($rows) {

        $table_ = "<table class=\"tb_html\" width=\"100%\" border=\"0px\">";

        if ($rows == NULL) {
            return NULL;
        } else {
            $icount = 0;
            foreach ($rows as $row) {
                $icount++;

                if (is_array($row) && $icount == 1) {
                    $table_ .= "<tr style=\"background:#222;color:#fff;\">";
                    foreach ($row as $tKey => $tValue) {
                        if (is_string($tKey)) {

                            $table_ .= "<td style=\"background:#555;color:#fff;font-size:10px;\">" . strtoupper($tKey) . "</td>";
                        }
                    }
                    $table_ .= "</tr>";
                }

                if ($icount % 2 == 0) {
                    $table_ .= "<tr style=\"background:#ddd;\">";
                } else {
                    $table_ .= "<tr style=\"background:#fff;\">";
                }

                if (is_array($row)) {
                    foreach ($row as $tKey => $tValue) {
                        if (is_string($tKey)) {

                            $table_ .= "<td style=\"color:#000;font-size:12px;\">" . str_replace(array("\r\n", "\n", "\r", "\t", "'"), "", isset($tValue)?$tValue:"") . "</td>";
                        }
                    }
                }
                $table_ .= "</tr>";
            }
        }
        $table_ .= "</table>";

        return $table_;
    }

    function util_report_html_select($rows, $property) {

        $select_ = "<select";
        if (isset($property)) {
            $select_ .=isset($property['id']) ? " id=\"" . $property['id'] . "\"" : "";
            $select_ .=isset($property['name']) ? " name=\"" . $property['name'] . "\"" : "";
            $select_ .=isset($property['class']) ? " class=\"" . $property['class'] . "\"" : "";
            $select_ .=isset($property['style']) ? " style=\"" . $property['style'] . "\"" : "";
            $select_ .=isset($property['size']) ? " size=\"" . $property['size'] . "\"" : " size=\"1\"";
            $select_ .=">";

            if ($rows == NULL) {
                return NULL;
            } else {
                foreach ($rows as $row) {
                    $select_ .= "<option ";
                    $select_ .= isset($property['value']) ? " value=\"" . $row[$property['value']] . "\"" : "";
                    $select_ .=">";
                    $select_ .= str_replace(array("\r\n", "\n", "\r", "\t"), "", (isset($property['text']) && strlen($property['text']) > 1) ? $row[$property['text']] : (isset($property['value']) ? $row[$property['value']] : "") );
                    $select_.="</option>";
                }
            }
        }
        $select_ .= "</select>";

        return $select_;
    }
