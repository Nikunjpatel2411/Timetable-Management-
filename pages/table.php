<?php
	include('../dist/includes/dbcon.php');
	if(isset($_POST['sub_code'])){
		$sub_code = $_POST['sub_code'];
		$query = "SELECT s.member_id, concat(m.member_first,' ', m.member_last) as Faculty_name,s.subject_code,sub.subject_weightage, COUNT(*) AS Total_Lecture,sub.subject_weightage-COUNT(*)As Remaining
		FROM schedule s
		LEFT JOIN member m ON s.member_id = m.member_id
		LEFT JOIN subject sub ON s.subject_code=sub.subject_code
		where s.subject_code='$sub_code'
		GROUP BY s.member_id, s.subject_code
		Order By Total_Lecture desc";
		$result = mysqli_query($con, $query);
        $query1="select subject_title from subject where subject_code='$sub_code'";
        $resul1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_assoc($resul1);
		if(mysqli_num_rows($result)>0){
            echo "Subject: "; 
            echo "<b>";
            echo $row1["subject_title"];
            echo "</b>";
            echo "<br><br>";
            echo "<table class= tabel table-bordered table-striped  id='myTable' width='800'>";
			echo "<tr>";
			echo "<th style='text-align: center;'>Faculty Name</th>";
			echo "<th style='text-align: center;'>Weightage</th>";
			echo "<th style='text-align: center;'>Total Lecture</th>";
            echo "<th style='text-align: center;'>Remaining</th>";
			echo "</tr>";

			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td style='text-align: center;'>" . $row['Faculty_name'] . "</td>";
				echo "<td style='text-align: center;'>" . $row['subject_weightage'] . "</td>";
				echo "<td style='text-align: center;'>" . $row['Total_Lecture'] . "</td>";
                echo "<td style='text-align: center;'>" . $row['Remaining'] . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		} else {
			echo "No data found.";
		}
	}
	?>