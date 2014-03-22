<?php
Class Api_model extends CI_Model {
	
	function generator_get($race, $limit) {
		$sql = "SELECT nickname, race FROM name_generator WHERE race = ? LIMIT ?";
		$query = $this->db->query($sql, array($race, $limit));
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return FALSE;
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
			return FALSE;
		}
	}

	function checkAvailibility($data, $table, $column) {
		$sql = "SELECT COUNT(*) AS pocet FROM {$table} WHERE {$column} = ?";
		$query = $this->db->query($sql, array($data));
		foreach ($query->result() as $row) {
			return $row->pocet;
		}
	}

	function registerUserChar($data, $ip, $salt) {
		if (is_array($data)) {
			// Perform transaction to register user and his character
				$sql_user = "INSERT INTO users (username, email, password, birthday, regip, salt) VALUES(?, ?, ?, ?, ?, ?)";
				$sql_character = "INSERT INTO characters (race, origin_race, charname, gender, age, id_user) VALUES(?, ?, ?, ?, ?, ?)";
				$sql_delete_generator = "DELETE FROM name_generator WHERE nickname = ?";
				$password = sha1($salt . $data['password'] . $salt);
			$this->db->trans_start();
				$this->db->query($sql_user, array($data['username'], $data['email'], $password, $data['date'], $ip, $salt));
				$this->db->query($sql_character, array($data['race'], $data['race'], $data['charname'], $data['gender'], $data['age'], $this->db->insert_id()));
				$this->db->query($sql_delete_generator, array($data['charname']));
			$this->db->trans_complete();

			return $this->db->trans_status();
		}
		else {
			return FALSE;
		}
	}
}
?>