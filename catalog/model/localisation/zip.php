<?php
class ModelLocalisationZip extends Model {
	public function getZips($zip) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zips WHERE zip_id = '" . (int)$zip . "' AND status = '1'");

		return $query->row;
	}

	
	public function getZip($zip, $zone_code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zips z,". DB_PREFIX  ."zone zo WHERE z.zip_id = " . (int)$zip . " AND "  . " zo.code = z.state AND z.status = '1'");
	
		return $query->row;
	}
	
	public function getZipsByCountyId($county_id) {
		$zip_data = $this->cache->get('zip.' . (int)$county_id);

		if (!$zip_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zips WHERE country = '" . (int)$county_id . "' AND status = '1' ORDER BY name");

			$zip_data = $query->rows;

			$this->cache->set('zip.' . (int)$county_id, $zip_data);
		}

		return $zip_data;
	}
}