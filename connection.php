<?php
	DEFINE("DB_SERVER", "localhost");
	DEFINE("DB_USERNAME", "root");
	DEFINE("DB_PASSWORD", "");
	DEFINE("DB_NAME", "new_event");

	function openConnection(){
		$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

		if($con === false)
			die("ERROR: Could not Connect " . mysqli_connect_error());
		
		return $con;
	}

	function closeConnection($con){
		mysqli_close($con);
	}

	function getRecord($con, $strSql){
		$arrRec = [];
		$i = 0;

		if ($rs = mysqli_query($con, $strSql)) {
			if(mysqli_num_rows($rs) > 0) {
				while($rec = mysqli_fetch_array($rs)){
					foreach ($rec as $key => $value) {
						$arrRec[$i][$key] = $value;
					}
					$i++;
				}
			}
			mysqli_free_result($rs);
		}
		else
			die("ERROR: Could not Execute your request!");

		return $arrRec;
		}
	
		function getEventCountByUser($user_id) {
			$connection = openConnection();

			$sql = "SELECT COUNT(*) AS event_count FROM events WHERE user_id = ?";
			$stmt = mysqli_prepare($connection, $sql);

			mysqli_stmt_bind_param($stmt, "i", $user_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $event_count);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($connection);

			return $event_count;
		}

		function getTotalDistinctSessionTitlesByUser($user_id) {
			$connection = openConnection();
			
			$sql = "SELECT COUNT(DISTINCT es.session_title) AS total_count
					FROM event_sessions es
					INNER JOIN events e ON es.event_id = e.event_id
					WHERE e.user_id = ?";
			$stmt = mysqli_prepare($connection, $sql);

			mysqli_stmt_bind_param($stmt, "i", $user_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $total_count);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($connection);
			
			return $total_count;
		}

		function getTotalDistinctSessionTitlesByEvent($event_id) {
			// Open database connection
			$connection = openConnection();
			
			// SQL query to count distinct session titles for a given event
			$sql = "SELECT COUNT(DISTINCT es.session_title) AS total_count
					FROM event_sessions es
					WHERE es.event_id = ?";
			
			// Prepare and execute the SQL statement
			$stmt = mysqli_prepare($connection, $sql);
			mysqli_stmt_bind_param($stmt, "i", $event_id);
			mysqli_stmt_execute($stmt);
			
			// Bind the result to a variable
			mysqli_stmt_bind_result($stmt, $total_count);
			mysqli_stmt_fetch($stmt);
			
			// Close the statement and connection
			mysqli_stmt_close($stmt);
			mysqli_close($connection);
			
			// Return the total count of distinct session titles
			return $total_count;
		}
		

		function getTotalDistinctSpeakersByUser($user_id) {
			$connection = openConnection();
			
			$sql = "SELECT COUNT(DISTINCT es.speaker) AS total_count
					FROM event_sessions es
					INNER JOIN events e ON es.event_id = e.event_id
					WHERE e.user_id = ?";
			$stmt = mysqli_prepare($connection, $sql);
			
			mysqli_stmt_bind_param($stmt, "i", $user_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $total_count);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($connection);
			
			return $total_count;
		}
		
		function getTotalDistinctParticipantsByUser($user_id) {
			$connection = openConnection();
			
			$sql = "SELECT COUNT(*) AS total_count
					FROM events e
					INNER JOIN participants p ON e.event_id = p.event_id
					WHERE e.user_id = ?";
			$stmt = mysqli_prepare($connection, $sql);
			
			mysqli_stmt_bind_param($stmt, "i", $user_id);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $total_count);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($connection);
			
			return $total_count;
		}

		
		function getParticipantsByEvent($eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT *
				FROM participants p
				JOIN events e ON p.event_id = e.event_id
				WHERE e.event_id = ?
			";

			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}

			$stmt->bind_param("i", $eventId);
			$stmt->execute();
			$result = $stmt->get_result();

			$participants = [];
			while ($row = $result->fetch_assoc()) {
				$participants[] = $row;
			}

			$stmt->close();
			$conn->close();

			return $participants;
		}

		function getParticipantAttendance($participantId, $eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT *
				FROM attendance
				WHERE participants_id = ? AND event_id = ?
			";
		
			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}
		
			$stmt->bind_param("ii", $participantId, $eventId);
			$stmt->execute();
			$result = $stmt->get_result();
		
			$attendance = [];
			while ($row = $result->fetch_assoc()) {
				$attendance[] = $row;
			}
		
			$stmt->close();
			$conn->close();
		
			return $attendance;
		}

		function getProductByUser($participEmail, $eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT *
				FROM product_recommend
				WHERE email = ? AND event_id = ?
			";
		
			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}
		
			$stmt->bind_param("ii", $participEmail, $eventId);
			$stmt->execute();
			$result = $stmt->get_result();
		
			$product = [];
			while ($row = $result->fetch_assoc()) {
				$product[] = $row;
			}
		
			$stmt->close();
			$conn->close();
		
			return $product;
		}

		function getCommentByUser($participEmail, $eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT *
				FROM comment
				WHERE email = ? AND event_id = ?
			";
		
			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}
		
			$stmt->bind_param("ii", $participEmail, $eventId);
			$stmt->execute();
			$result = $stmt->get_result();
		
			$comment = [];
			while ($row = $result->fetch_assoc()) {
				$comment[] = $row;
			}
		
			$stmt->close();
			$conn->close();
		
			return $comment;
		}

		function getSessionByEvent($eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT DISTINCT session_title
				FROM event_sessions
				WHERE event_id = ?
			";
		
			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}
		
			$stmt->bind_param("i", $eventId);
			$stmt->execute();
			$result = $stmt->get_result();
		
			$event_session = [];
			while ($row = $result->fetch_assoc()) {
				$event_session[] = $row;
			}
		
			$stmt->close();
			$conn->close();
		
			return $event_session;
		}

		function getAttendanceCountBySession($session_title, $eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT COUNT(*) as count
				FROM attendance
				WHERE event_id = ? AND session_title = ?
			";
		
			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}
		
			$stmt->bind_param("is", $eventId, $session_title); // Note: "is" for integer and string parameters
			$stmt->execute();
			$result = $stmt->get_result();
		
			$row = $result->fetch_assoc();
			$count = $row['count']; // Fetch the count value
		
			$stmt->close();
			$conn->close();
		
			return $count;
		}

		function getRecommendedSessionCount($session_title, $eventId) {
			$conn = openConnection();
			
			$query = "
				SELECT COUNT(*) as count
				FROM sesion_recommend
				WHERE event_id = ? AND session_title = ?
			";
		
			$stmt = $conn->prepare($query);
			if ($stmt === false) {
				die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
			}
		
			$stmt->bind_param("is", $eventId, $session_title); // Note: "is" for integer and string parameters
			$stmt->execute();
			$result = $stmt->get_result();
		
			$row = $result->fetch_assoc();
			$count = $row['count']; // Fetch the count value
		
			$stmt->close();
			$conn->close();
		
			return $count;
		}
		
		


?>
