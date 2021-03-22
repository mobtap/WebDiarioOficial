<style>
#calendar-outer {
	width: 300px;
}

#calendar-outer ul {
	margin: 0px;
	padding: 0px;
}

#calendar-outer ul li {
	margin: 0px;
	padding: 0px;
	list-style-type: none;
}

.prev {
	display: inline-block;
	float: left;
	cursor: pointer
}

.next {
	display: inline-block;
	float: right;
	cursor: pointer
}

#currentYear:focus {
	outline: none;
	background: #ff8e8e;
}

div.calendar-nav {
	background-color: #E1271B;
	text-align: center;
	width: 294px;
	height: 40px;
	color: #FFF;
	box-sizing: border-box;
	font: 15px/1.5 "Helvetica Neue", Helvatica, Arial, san-serif;
	line-height: 40px;
	font-weight: bold;
}

#calendar-outer .week-name-title li {
	width: 42px;
	height: 40px;
	display: inline-block;
	color: #90918b;
	font: 13px/1.5 "Helvetica Neue", Helvatica, Arial, san-serif;
	text-align: center;
	line-height: 40px;
}

.week-day-cell li {
	width: 40px;
	height: 30px;
	display: inline-block;
	text-align: center;
	vertical-align: middle;
	background-color: #ffffff;
	color: #000000;
	border: 1px solid #f1f0f0;
	font: 13px/1.5 "Helvetica Neue", Helvatica, Arial, san-serif;
	line-height: 33px;
}
#body-overlay {background-color: rgba(0, 0, 0, 0.6);z-index: 999;position: absolute;left: 0;top: 0;width: 100%;height: 100%;display: none;}
#body-overlay div {position:absolute;left:50%;top:50%;margin-top:-32px;margin-left:-32px;}
</style>
<?php
include '../db.inc.php';
class PHPCalendar {
	private $weekDayName = array ("SEG","TER","QUA","QUI","SEX","SAB","DOM");
	private $currentDay = 0;
	private $currentMonth = 0;
	private $currentYear = 0;
	private $currentMonthStart = null;
	private $currentMonthDaysLength = null;	
	
	function __construct() {
		$this->currentYear = date ( "Y", time () );
		$this->currentMonth = date ( "m", time () );
		
		if (! empty ( $_POST ['year'] )) {
			$this->currentYear = $_POST ['year'];
		}
		if (! empty ( $_POST ['month'] )) {
			$this->currentMonth = $_POST ['month'];
		}
		$this->currentMonthStart = $this->currentYear . '-' . $this->currentMonth . '-01';
		$this->currentMonthDaysLength = date ( 't', strtotime ( $this->currentMonthStart ) );
	}
	
	function getCalendarHTML() {
		$calendarHTML = '<div id="calendar-outer">'; 
		$calendarHTML .= '<div class="calendar-nav">' . $this->getCalendarNavigation() . '</div>'; 
		$calendarHTML .= '<ul class="week-name-title">' . $this->getWeekDayName () . '</ul>';
		$calendarHTML .= '<ul class="week-day-cell">' . $this->getWeekDays () . '</ul>';		
		$calendarHTML .= '</div>';
		return $calendarHTML;
	}
	
	function getCalendarNavigation() {
		$nomemes = array ("JANEIRO","FEVEREIRO","MARCO","ABRIL","MAIO","JUNHO","JULHO","AGOSTO","SETEMBRO","OUTUBRO","NOVEMBRO","DEZEMBRO");
		$prevMonthYear = date ( 'm,Y', strtotime ( $this->currentMonthStart. ' -1 Month'  ) );
		$prevMonthYearArray = explode(",",$prevMonthYear);
		$mm = trim(date ( 'm ', strtotime ( $this->currentMonthStart ) ));
		$nmes = $nomemes[$mm];
		$nextMonthYear = date ( 'm,Y', strtotime ( $this->currentMonthStart . ' +1 Month'  ) );
		$nextMonthYearArray = explode(",",$nextMonthYear);
		
		#$navigationHTML = '<div class="prev" data-prev-month="' . $prevMonthYearArray[0] . '" data-prev-year = "' . $prevMonthYearArray[1]. '">&nbsp&nbsp;<</div>'; 
		$navigationHTML .= '<span id="currentMonth"> ' . $nmes . ' </span>';
		$navigationHTML .= '<span contenteditable="true" id="currentYear">'.	date ( 'Y', strtotime ( $this->currentMonthStart ) ) . '</span>';
		#$navigationHTML .= '<div class="next" data-next-month="' . $nextMonthYearArray[0] . '" data-next-year = "' . $nextMonthYearArray[1]. '">>&nbsp&nbsp</div>';
		return $navigationHTML;
	}
	
	function getWeekDayName() {
		$WeekDayName= '';		
		foreach ( $this->weekDayName as $dayname ) {			
			$WeekDayName.= '<li>' . $dayname . '</li>';
		}		
		return $WeekDayName;
	}
	
	function getWeekDays() {
		$dt = $this->currentMonth."/".$this->currentYear;
		$weekLength = $this->getWeekLengthByMonth ();
		$firstDayOfTheWeek = date ( 'N', strtotime ( $this->currentMonthStart ) );
		$weekDays = "";
		for($i = 0; $i < $weekLength; $i ++) {
			for($j = 1; $j <= 7; $j ++) {
				$cellIndex = $i * 7 + $j;
				$cellValue = null;
				if ($cellIndex == $firstDayOfTheWeek) {
					$this->currentDay = 1;
				}
				if (! empty ( $this->currentDay ) && $this->currentDay <= $this->currentMonthDaysLength) {
					$cellValue = $this->currentDay;
					$this->currentDay ++;
				}
				$dd = pg_query("select to_char(die_datacadastro,'dd/mm/yyyy') as edi_data from diario where to_char(die_datacadastro,'dd')='".((strlen($cellValue)==1)?"0".$cellValue:$cellValue)."' ") or die(pg_last_error());
					if(pg_num_rows($dd)!=0) {
						$dt_click = (((strlen($cellValue)==1)?"0".$cellValue:$cellValue))."/".$this->currentMonth."/".$this->currentYear;
					$weekDays .= '<li style="background-color:#FFE9E9" onclick=\'location.href="index.php?busca='.$dt_click.'"\'><b>' . $cellValue . '</b></li>';
					} else {
					$weekDays .= '<li>' . $cellValue . '</li>';
					}
			}
		}
		return $weekDays;
	}
	
	function getWeekLengthByMonth() {
		$weekLength =  intval ( $this->currentMonthDaysLength / 7 );	
		if($this->currentMonthDaysLength % 7 > 0) {
			$weekLength++;
		}
		$monthStartDay= date ( 'N', strtotime ( $this->currentMonthStart) );		
		$monthEndingDay= date ( 'N', strtotime ( $this->currentYear . '-' . $this->currentMonth . '-' . $this->currentMonthDaysLength) );
		if ($monthEndingDay < $monthStartDay) {			
			$weekLength++;
		}
		
		return $weekLength;
	}
}



?>