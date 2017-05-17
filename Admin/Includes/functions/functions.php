<?php
	/*
	** title function V1.0  that echo the page title in 
	**case the page has variable $pageTitle and echo defult title for other pages
	*/
	/*start function title*/
	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;
		} else {

			echo 'Defult';
		}

	}

	/*end function title*/


	/*start check item function V1.0 */

	/*
	**function accept parameters
	** $select = the item to select [Example: user, item]
	** $from = the table to select from [Example: user, item]
	** $value = the value of select 
	*/

	function checkItme($select, $from, $value) {
		global $conn;

		$st = $conn->prepare("SELECT $select FROM $from WHERE $select = ? ");
		$st->execute(array($value));

		$count = $st->rowCount();

		return $count;

	}

	/*end check item function V1.0 */

	/*redirect function start*/

	/*
	** Home Redirect Function[This Function Accept Prameters]V2.0
	** $msg = echo the massage [ error | scusess| warning ]
	** $url = the link that will make redirect
	** $secong = seconds before redirecting
	*/

	function redirect($msg, $url = null, $page = 'home ', $seconds = 3) {

		if ($url === null) {
			$url = 'index.php';
		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

			$url = $_SERVER['HTTP_REFERER'];
			
			} else {
				$url = 'index.php';
			}


		}


		echo $msg;

		echo "<div class='alert alert-info' style='font-size: 17px; text-align: center; '>you will direct to the $page page after $seconds seconds</div>";


		header("refresh: $seconds;url=$url");

		exit();

	}

	/*redirect function end*/

	/* start check item count function V1.0 */
	
	/*
	**function use to count the items rows
	** function use parameter
	** $item = use item to count about it [ users | items ]
	** $table = the required table to count from [ users | product ] 
	*/

	function countItem($item, $table, $value) {
		global $conn;

		$stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table WHERE UserID = ?");

		$stmt2->execute(array($value));

		return $stmt2->fetchColumn();
	}

	/* end check item count function V1.0 */
