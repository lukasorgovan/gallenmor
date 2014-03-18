<?php
Class Api_model extends CI_Model {
	
	function generator_get($race, $limit) {
		$sql = "SELECT nickname, race FROM name_generator WHERE race = ? LIMIT ?";
		$query = $this->db->query($sql, array($race, $limit));
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	function generator_post($race, $name) {
		$ci =& get_instance();
		$ci->load->helper('messages_helper');
		$messages = system_messages();
		
		$sql = "INSERT INTO name_generator (nickname, race) VALUES (?, ?)";
		$query = $this->db->query($sql, array($name, $race));
		if ($this->db->affected_rows() === 1) {
			return $messages['name_added'];
		}
		else {
			return $messages['error_generate_name'];
		}
	}

	function races_get() {
		$sql = "SELECT * FROM races";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data = array();
			foreach ($query->result() as $row) {
				$data[$row->codename] = array(
					"id" => $row->id,
					"name" => $row->name,
					"description" => $row->description,
					"racial" => $row->racial,
					"history" => $row->history,
					"minage" => $row->minage,
					"maxage" => $row->maxage
					);
			} 
			return $data;
		}
		else {
			return false;
		}
	}

	function checkAvailibility($data, $table, $column) {
		$sql = "SELECT COUNT(*) AS pocet FROM {$table} WHERE {$column} = ?";
		$query = $this->db->query($sql, array($data));
		foreach ($query->result() as $row) {
			return $row->pocet;
		}
	}
}
?>